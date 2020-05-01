<?php

namespace Nikservik\Subscriptions\CloudPayments;

class TokenChargeRequest
{
    protected $data;

    function __construct($price, $currency, $token, $userId, $description)
    {
        $this->data = [
            'Amount' => $price, 
            'Currency' => $currency, 
            'AccountId' => $userId,
            'Token' => $token, 
            'Description' => $description,
            'JsonData' => [
                'cloudPayments' => (new Receipt($userId, [new ReceiptItem($description, $price)]))
                                        ->toArray()
            ],
        ];
    }

    public function toArray()
    {
        return $this->data;
    }
}