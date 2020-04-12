<?php

namespace App\Subscriptions;

use App\Subscriptions\Subscription;
use App\Subscriptions\Tariff;
use App\User;
use Carbon\Carbon;

class Manager
{
    public static function activate(User $user, Tariff $tariff)
    {
        $subscription = self::createSubscriptionFromTariff($tariff);

        $user->subscriptions()->save($subscription);

        self::endPreviousSubscription($user, $subscription);
    }

    public static function activateDefault(User $user)
    {
        self::activate($user, self::defaultTariff());
    }

    public static function defaultTariff()
    {
        return Tariff::where('availability->default', true)->first();
    }

    public static function endOutdatedSubscriptions()
    {
        $outdated = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('prolongable', false)->get();

        foreach ($outdated as $subscription) {
            $subscription->status = 'Ended';
            self::activate($subscription->user, self::defaultTariff());
        }
    }

    protected static function createSubscriptionFromTariff(Tariff $tariff)
    {
        $subscription = Subscription::make($tariff->toArray());
        $subscription->tariff_id = $tariff->id;
        $subscription->status = 'Active';
        $subscription->features = $tariff->features;

        if ($tariff->period != 'endless') 
            $subscription->next_transaction_date = Carbon::now()->add($tariff->period);

        return $subscription;
    }

    protected static function endPreviousSubscription(User $user, Subscription $newSubscription)
    {
        $user->subscriptions()->where('status', 'Active')
            ->where('id', '<>', $newSubscription->id)
            ->update(['status' => 'Ended']);
    }
}