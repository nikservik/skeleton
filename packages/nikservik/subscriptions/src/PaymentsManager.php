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
use Nikservik\Subscriptions\Models\Tariff;



class PaymentsManager 
{

    public function charge(Subscription $subscription)
    {
        if (! ($bill = $this->prepareBill($subscription)))
            return false;

        $response = CloudPaymentsFacade::tokensCharge($bill);
        Log::debug($response);

        if (! $this->isGoodResponse($response))
            return false;

        return $this->savePayment($response['Model']);
    }

    public function processPaymentConfirmation(Request $request)
    {
        if (! CloudPayments::validateSecrets($request))
            return false;

        if (! $subscription = $this->getSubscription($request->all()))
            return false;
        $request->merge(['InvoiceId' => $subscription->id]);

        if (! $payment = $this->savePayment($request->all()))
            return false;

        $this->saveCardData($request->Token, $request->CardLastFour, $request->AccountId);
    
        if (Subscriptions::needActivation($subscription)) {
            Subscriptions::confirmActivation($subscription);
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
            'InvoiceId' => $subscription->id,
        ];
    }

    protected function savePayment($data)
    {
        $validator = Validator::make($data, [
            'AccountId' => 'required|numeric',
            'TransactionId' => 'required|numeric|unique:payments,remote_transaction_id',
            'CardLastFour' => 'required|numeric',
            'Amount' => 'required|numeric',
            'Currency' => 'required',
            'Status' => 'required',
            'InvoiceId' => 'required|numeric',
        ]);

        if ($validator->fails())  {
            Log::debug($validator->errors());
            return false;
        }

        return Payment::create([
            'subscription_id' => $data['InvoiceId'], 
            'user_id' => $data['AccountId'], 
            'remote_transaction_id' => $data['TransactionId'], 
            'card_last_digits' => $data['CardLastFour'],
            'amount' => $data['Amount'], 
            'currency' => $data['Currency'], 
            'status' => $data['Status'], 
        ]);
    }

    protected function saveCardData($token, $cardLastFour, $userId)
    {
        if (! $token or ! $cardLastFour or ! $user = User::find($userId))
            return;

        $user->token = $token;
        $user->cardLastFour = $cardLastFour;
        $user->save();
    }

    public function getSubscription($data)
    {
        if (array_key_exists('InvoiceId', $data))
            return Subscription::find($data['InvoiceId']);

        if (! array_key_exists('Data', $data))
            return false;

        $tariffData = json_decode($data['Data'], true);

        if (! array_key_exists('tariff_id', $tariffData))
            return false;

        return Subscriptions::activate(
                User::find($data['AccountId']),
                Tariff::find($tariffData['tariff_id'])
        );
    }

    public function isGoodResponse($response)
    {
        return array_key_exists('Success', $response) and $response['Success'] 
            and array_key_exists('Model', $response) and is_array($response['Model'])
            and array_key_exists('Status', $response['Model']) 
            and $response['Model']['Status'] == 'Completed';
    }
}