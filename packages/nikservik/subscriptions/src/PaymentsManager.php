<?php

namespace Nikservik\Subscriptions;

use Nikservik\Subscriptions\Models\Subscription;



class PaymentsManager 
{
    public function charge(Subscription $subscription)
    {
        return true;
    }
}