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
        if (! ($bill = $this->prepareTokenBill($subscription)))
            return false;

        $response = CloudPaymentsFacade::tokensCharge($bill);

        if (! $this->successResponse($response))
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

    public function chargeByCrypt(User $user, Tariff $tariff, string $cardholderName, string $ip,  string $crypt)
    {
        $bill = [
            'Amount' => $tariff->price, 
            'Currency' => $tariff->currency, 
            'IpAddress' => $ip, 
            'Name' => $cardholderName, 
            'CardCryptogramPacket' => $crypt, 
            'Description' => __('subscriptions::payments.description', ['app' => config('app.url')]),
            'AccountId' => $user->id,
            'JsonData' => json_encode([
                'tariff_id' => $tariff->id,
                'activation' => true,
            ]),
        ];

        return $this->activateSubscriptionByResponse($user, $tariff, 
            CloudPaymentsFacade::cardsCharge($bill));
    }

    public function post3ds(User $user, Tariff $tariff, int $transactionId, string $paRes)
    {
        $bill = [
            'TransactionId' => $transactionId,
            'PaRes' => $paRes,
        ];
        
        return $this->activateSubscriptionByResponse($user, $tariff, 
            CloudPaymentsFacade::cardsPost3ds($bill));
    }

    protected function activateSubscriptionByResponse(User $user, Tariff $tariff, array $response)
    {
        if (! $this->successResponse($response) and ! $this->need3dSecureResponse($response))
            return $this->getErrorMessage($response);

        if ($this->need3dSecureResponse($response))
            return $response['Model'];

        if (! $subscription = Subscriptions::activate($user, $tariff, true))
            return 'errors.failed';

        $response['Model']['InvoiceId'] = $subscription->id;
        $this->savePayment($response['Model']);

        return $subscription;
    }

    protected function prepareTokenBill(Subscription $subscription)
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
        if (array_key_exists('InvoiceId', $data) and $data['InvoiceId'])
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

    public function successResponse($response)
    {
        return array_key_exists('Success', $response) and $response['Success'] 
            and array_key_exists('Model', $response) and is_array($response['Model'])
            and array_key_exists('Status', $response['Model']) 
            and $response['Model']['Status'] == 'Completed';
    }

    public function need3dSecureResponse($response)
    {
        return array_key_exists('Success', $response) and !$response['Success'] 
            and array_key_exists('Model', $response) and is_array($response['Model'])
            and array_key_exists('PaReq', $response['Model']) 
            and array_key_exists('AcsUrl', $response['Model']);
    }

    protected function getErrorMessage($response)
    {
        if (! is_array($response) or ! array_key_exists('Model', $response))
            return 'errors.undefined';

        return 'errors.'.$response['Model']['ReasonCode'];
    }
}