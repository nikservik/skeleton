<?php 

namespace Nikservik\Subscriptions\Traits;

use Nikservik\Subscriptions\Models\Subscription as SubscriptionModel;

trait Subscription
{
    public function subscriptions()
    {
        return $this->hasMany(SubscriptionModel::class);
    }

    public function subscription()
    {
        return $this->subscriptions()->where('status', 'Active')->first();
    }

    public function getFeaturesAttribute() 
    {
        if ($this->subscription() and $this->subscription()->features)
            return $this->subscription()->features;

        return [];
    }   
}