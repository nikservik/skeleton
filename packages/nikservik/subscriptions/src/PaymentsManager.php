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

        return $this->savePayment(
            $this->prepareResponseToSave($response)
        );
    }

    public function processPaymentConfirmation(Request $request)
    {
        if (! CloudPayments::validateSecrets($request))
            return false;

        if (! $subscription = $this->getSubscription($request->all()))
            return false;
        $request->merge(['subscription_id' => $subscription->id]);

        if (! $payment = $this->savePayment($request->all()))
            return false;

        if ($this->needActivation($request->all())) {
            $this->saveToken($request->Token, $request->AccountId);
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
            'JsonData' => [
                'subscription_id' => $subscription->id,
                'activation' => false,
            ],
        ];
    }

    protected function savePayment($data)
    {
        $validator = Validator::make($data, [
            'AccountId' => 'required|numeric',
            'TransactionId' => 'required|numeric',
            'CardLastFour' => 'required|numeric',
            'Amount' => 'required|numeric',
            'Currency' => 'required',
            'Status' => 'required',
            'subscription_id' => 'required|numeric',
        ]);

        if ($validator->fails()) 
            return false;

        return Payment::create([
            'subscription_id' => $data['subscription_id'], 
            'user_id' => $data['AccountId'], 
            'remote_transaction_id' => $data['TransactionId'], 
            'card_last_digits' => $data['CardLastFour'],
            'amount' => $data['Amount'], 
            'currency' => $data['Currency'], 
            'status' => $data['Status'], 
        ]);
    }

    protected function saveToken($token, $userId)
    {
        if (! $token or ! $user = User::find($userId))
            return;

        $user->token = $token;
        $user->save();
    }

    public function getSubscription($data)
    {
        if (! array_key_exists('Data', $data) and ! array_key_exists('JsonData', $data))
            return false;

        $subscriptionData = json_decode(
            array_key_exists('Data', $data) ? $data['Data'] : $data['JsonData'],
            true
        );

        if (! array_key_exists('subscription_id', $subscriptionData) 
            and ! array_key_exists('tariff_id', $subscriptionData))
            return false;

        if (array_key_exists('tariff_id', $subscriptionData)) {
            if(! ($subscription = Subscriptions::activate(
                User::find($data['AccountId']),
                Tariff::find($subscriptionData['tariff_id'])
            )))
                return false;

            return $subscription;
        } 

        return Subscription::find($subscriptionData['subscription_id']);
    }

    public function needActivation($data)
    {
        $activationData = json_decode($data['Data'], true);
        return array_key_exists('activation', $activationData) and $activationData['activation'];
    }

    public function isGoodResponse($response)
    {
        return array_key_exists('Success', $response) and $response['Success'] 
            and array_key_exists('Model', $response) and is_array($response['Model'])
            and array_key_exists('Status', $response['Model']) 
            and $response['Model']['Status'] == 'Completed';
    }

    public function prepareResponseToSave($response)
    {
        return array_merge($response['Model'], $response['Model']['JsonData']);
    }
}