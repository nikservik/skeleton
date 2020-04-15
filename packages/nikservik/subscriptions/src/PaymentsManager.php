<?php

namespace Nikservik\Subscriptions;

use Albakov\LaravelCloudPayments\Facade as CloudPaymentsFacade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Nikservik\Subscriptions\Facades\CloudPayments;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Payment;
use Nikservik\Subscriptions\Models\Subscription;



class PaymentsManager 
{

    public function charge(Subscription $subscription)
    {
        if (! ($bill = $this->prepareBill($subscription)))
            return false;

        $result = CloudPaymentsFacade::tokensCharge($bill);

        return array_key_exists('code', $result) and $result['code'] == 0;
    }

    public function processPaymentConfirmation(Request $request)
    {
        if (! CloudPayments::validateSecrets($request))
            return false;

        if (! $payment = $this->savePayment($request))
            return false;

        if (json_decode($request->Data, true)['activation']) {
            $this->saveToken($request, $payment->user);
            Subscriptions::confirmActivation($payment->subscription);
        }
        return true;
    }

    protected function prepareBill(Subscription $subscription)
    {
        if (! $subscription->price > 0 or ! $subscription->prolongable)
            return false;

        if (! $subscription->user or ! $subscription->user->token)
            return false;

        return [
            'Amount' => $subscription->price, 
            'Currency' => $subscription->currency, 
            'AccountId' => $subscription->user->id,
            'Token' => $subscription->user->token, 
            'Description' => __('subscriptions::payments.description', ['app' => config('app.url')]),
            'Email' => $subscription->user->email,
            'JsonData' => [
                'subscription_id' => $subscription->id,
                'activation' => false,
            ],
        ];
    }

    protected function savePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'AccountId' => 'required|numeric',
            'TransactionId' => 'required|numeric',
            'CardLastFour' => 'required|numeric',
            'Amount' => 'required|numeric',
            'Currency' => 'required',
            'Status' => 'required',
            'Data' => 'required|json',
        ]);

        if ($validator->fails()) 
            return false;

        $data = json_decode($request->Data, true);
        if (! $data['subscription_id'])
            return false;

        return Payment::create([
            'subscription_id' => $data['subscription_id'], 
            'user_id' => $request->AccountId, 
            'remote_transaction_id' => $request->TransactionId, 
            'card_last_digits' => $request->CardLastFour,
            'amount' => $request->Amount, 
            'currency' => $request->Currency, 
            'status' => $request->Status, 
        ]);
    }

    protected function saveToken(Request $request, User $user)
    {
        if (! $request->has('Token'))
            return;

        $user->token = $request->Token;
        $user->save();
    }
}