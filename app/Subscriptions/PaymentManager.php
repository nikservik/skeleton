<?php

namespace App\Subscriptions;

use App\Subscriptions\Subscription;

class PaymentManager
{
    public static function charge(Subscription $subscription, $return)
    {
        return $return;
    }
}