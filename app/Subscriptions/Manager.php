<?php

namespace App\Subscriptions;

use App\Subscriptions\PaymentManager;
use App\Subscriptions\Subscription;
use App\Subscriptions\Tariff;
use App\User;
use Carbon\Carbon;

class Manager
{
    public static function activate(User $user, Tariff $tariff)
    {
        if ($tariff->price == 0)
            return self::activateFree($user, $tariff);
        else
            return self::activatePaid($user, $tariff);
    }

    public static function activateDefault(User $user)
    {
        return self::activateFree($user, self::defaultTariff());
    }

    public static function defaultTariff()
    {
        return Tariff::where('availability->default', true)->first();
    }

    public static function confirmActivation(Subscription $subscription)
    {
        $subscription->last_transaction_date = Carbon::now();
        $subscription->status = 'Active';
        $subscription->save();
        self::endPreviousSubscription($subscription);
        return $subscription;
    }

    public static function cancel(Subscription $subscription)
    {
        if ($subscription->next_transaction_date) 
            $subscription->status = 'Cancelled';
        else
            $subscription->status = 'Ended';
        $subscription->save();
        return $subscription;
    }

    public static function chargePaid($return = true)
    {
        $toCharge = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('status', 'Active')->where('price', '>', 0)->where('prolongable', true)->get();

        foreach ($toCharge as $subscription) {
            self::charge($subscription, $return);
        }
    }

    public static function endOutdated()
    {
        $outdated = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('prolongable', false)->get();

        foreach ($outdated as $subscription) {
            $subscription->status = 'Ended';
            $subscription->save();
            self::activateDefault($subscription->user);
        }
    }

    public static function endCancelled()
    {
        $outdated = Subscription::where('next_transaction_date', '<', Carbon::now())
            ->where('status', 'Cancelled')->get();

        foreach ($outdated as $subscription) {
            $subscription->status = 'Ended';
            $subscription->save();
            self::activateDefault($subscription->user);
        }
    }

    protected static function activateFree(User $user, Tariff $tariff)
    {
        $subscription = self::createSubscriptionFromTariff($tariff);
        $user->subscriptions()->save($subscription);
        self::endPreviousSubscription($subscription);
        return $subscription;
    }

    protected static function activatePaid(User $user, Tariff $tariff)
    {
        $subscription = self::createSubscriptionFromTariff($tariff);
        $subscription->status = 'Awaiting';
        $user->subscriptions()->save($subscription);
        return $subscription;
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

    protected static function endPreviousSubscription(Subscription $newSubscription)
    {
        $newSubscription->user->subscriptions()->where('status', 'Active')
            ->where('id', '<>', $newSubscription->id)
            ->update(['status' => 'Ended']);
    }

    protected static function charge(Subscription $subscription, $return)
    {
        if (PaymentManager::charge($subscription, $return)) {
            $subscription->next_transaction_date = Carbon::now()->add($subscription->period);
            $subscription->save();
        } else {
            if ($subscription->next_transaction_date < Carbon::now()->sub(config('subscriptions.past_due.reject'))) {
                $subscription->status = 'Rejected';
                $subscription->save();
                self::activateDefault($subscription->user);
            } else {
                $subscription->status = 'PastDue';
                $subscription->save();
            }
        }
    }
}