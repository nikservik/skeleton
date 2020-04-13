<?php

namespace Tests\Unit;

use App\Subscriptions\Manager;
use App\Subscriptions\Tariff;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class SubscriptionsPaidTest extends TestCase
{
    use DatabaseTransactions;

    protected function createTariffFree()
    {
        $tariffFree = new Tariff([
            'name' => 'Бесплатный',
            'short_name' => 'free',
            'price' => 0,
            'currency' => 'RUB',
            'period' => 'endless',
            'prolongable' => false,
        ]);
        $tariffFree->features = ['read-books'];
        $tariffFree->default = true;
        $tariffFree->save();

        return $tariffFree;
    }

    protected function createTariffPaid()
    {
        $tariffPaid = new Tariff([
            'name' => 'Платный',
            'short_name' => 'paid',
            'price' => 100,
            'currency' => 'RUB',
            'period' => '1 month',
            'prolongable' => true,
        ]);
        $tariffPaid->features = ['read-books','earn-money'];
        $tariffPaid->save();

        return $tariffPaid;
    }

    public function testActivatePaid()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Manager::activateDefault($user);
        $defaultSubscription = $user->subscription();
        $this->assertEquals($default->id, $defaultSubscription->tariff_id);

        $subscription = Manager::activate($user, $tariff);
        $this->assertNotNull($subscription);
        $this->assertEquals($tariff->id, $subscription->tariff_id);
        $this->assertEquals('Awaiting', $subscription->status);

        Manager::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($tariff->id, $newSubscription->tariff_id);
    }


    public function testCancelPaid()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Manager::activateDefault($user);
        $defaultSubscription = $user->subscription();
        $this->assertEquals($default->id, $defaultSubscription->tariff_id);

        $subscription = Manager::activate($user, $tariff);
        $this->assertNotNull($subscription);
        $this->assertEquals('Awaiting', $subscription->status);

        Manager::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        Manager::cancel($subscription);
        $subscription->refresh();
        $this->assertEquals('Cancelled', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Manager::endCancelled();
        $subscription->refresh();
        $this->assertEquals('Ended', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($default->id, $newSubscription->tariff_id);
    }


    public function testChargePaid()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Manager::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Manager::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Manager::chargePaid(); // оплата прошла
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);
        $this->assertEquals(Carbon::now()->add($tariff->period)->format('d.m.Y'), $subscription->next_transaction_date->format('d.m.Y'));
    }

    public function testChargePaidDeclined()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Manager::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Manager::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Manager::chargePaid(false); // оплата не прошла
        $subscription->refresh();
        $this->assertEquals('PastDue', $subscription->status);
        $this->assertNotEquals(Carbon::now()->add($tariff->period)->format('d.m.Y'), $subscription->next_transaction_date->format('d.m.Y'));
    }

    public function testRejectPastDue()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Manager::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Manager::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = 
            Carbon::now()->sub('1 day')->sub(config('subscriptions.past_due.reject'));
        $subscription->save();

        Manager::chargePaid(false); // оплата давно не прошла
        $subscription->refresh();
        $this->assertEquals('Rejected', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($default->id, $newSubscription->tariff_id);
    }
}
