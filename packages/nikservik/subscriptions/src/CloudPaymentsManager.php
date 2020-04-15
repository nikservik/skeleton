<?php

namespace Nikservik\Subscriptions;

use Illuminate\Http\Request;


class CloudPaymentsManager 
{
    public function validateSecrets(Request $request)
    {
        if (empty($secretCloudPayments = $request->header('Content-Hmac')))
            return false;

        $secret = base64_encode(
            hash_hmac(
                'sha256',
                file_get_contents('php://input'),
                config('cloudpayments.apiSecret'),
                true
            )
        );

        return $secret === $secretCloudPayments;
    }
}