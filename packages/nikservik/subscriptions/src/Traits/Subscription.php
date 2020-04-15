<?php 

namespace Nikservik\Subscriptions\Traits;

use Illuminate\Support\Arr;
use Nikservik\Subscriptions\Models\Payment;
use Nikservik\Subscriptions\Models\Subscription as SubscriptionModel;

trait Subscription
{
    public function subscriptions()
    {
        return $this->hasMany(SubscriptionModel::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
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

    public function getTokenAttribute() 
    {
        return Arr::get($this->settings, 'token', '');
    }   

    public function setTokenAttribute($token) 
    {
        $settings = $this->settings;
        $settings['token'] = $token;
        $this->settings = $settings;
    }   
}