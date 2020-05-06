<?php

namespace Tests\Unit;

use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;


class SubscriptionsFreeTest extends TestCase
{
    use DatabaseTransactions;

    protected function createTariffFree()
    {
        $tariffFree = new Tariff([
            'name' => 'Бесплатный',
            'slug' => 'free',
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

    protected function createTariffTrial()
    {
        $tariffTrial = new Tariff([
            'name' => 'Пробный',
            'slug' => 'trial',
            'price' => 0,
            'currency' => 'RUB',
            'period' => '15 days',
            'prolongable' => false,
        ]);
        $tariffTrial->features = ['read-books','earn-money'];
        $tariffTrial->save();

        return $tariffTrial;
    }

    protected function createTariffPaid()
    {
        $tariffPaid = new Tariff([
            'name' => 'Платный',
            'slug' => 'paid',
            'price' => 100,
            'currency' => 'RUB',
            'period' => '1 month',
            'prolongable' => true,
        ]);
        $tariffPaid->features = ['read-books','earn-money'];
        $tariffPaid->save();

        return $tariffPaid;
    }

    public function testSubscribe()
    {
        Mail::fake();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffFree();

        Subscriptions::activate($user, $tariff);

        $this->assertEquals(1, $user->subscriptions()->count());

        $subscription = $user->subscriptions()->first();
        $this->assertEquals($tariff->slug, $subscription->slug);
        $this->assertEquals($tariff->name, $subscription->name);
        $this->assertEquals($tariff->price, $subscription->price);
        $this->assertEquals($tariff->currency, $subscription->currency);
        $this->assertEquals($tariff->period, $subscription->period);
        $this->assertEquals($tariff->prolongable, $subscription->prolongable);

        $this->assertEquals(count($tariff->features), count($subscription->features));
        $this->assertEquals($tariff->features[0], $subscription->features[0]);

    }

    public function testSubscribePeriodic()
    {
        Mail::fake();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffTrial();

        Subscriptions::activate($user, $tariff);

        $this->assertEquals(1, $user->subscriptions()->count());

        $subscription = $user->subscription();
        $this->assertEquals($tariff->id, $subscription->tariff_id);
        $this->assertNotNull($subscription->next_transaction_date);
        $this->assertEquals(Carbon::now()->add($tariff->period)->format('d.m.Y'), $subscription->next_transaction_date->format('d.m.Y'));
    }

    public function testActivateSecondSubscription()
    {
        Mail::fake();
        $user = factory(User::class)->create();
        $tariff1 = $this->createTariffFree();
        $tariff2 = $this->createTariffTrial();

        Subscriptions::activate($user, $tariff1);
        $this->assertEquals(1, $user->subscriptions()->count());

        Subscriptions::activate($user, $tariff2);
        $this->assertEquals(2, $user->subscriptions()->count());
        $this->assertEquals(1, $user->subscriptions()->where('status', 'Active')->count());
        $subscription = $user->subscription();
        $this->assertEquals($tariff2->id, $subscription->tariff_id);
    }

    public function testDefaultTariff()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $tariff1 = $this->createTariffFree();
        $tariff2 = $this->createTariffTrial();

        $default = Subscriptions::defaultTariff();
        $this->assertEquals($tariff1->id, $default->id);
    }

    public function testSubscribeOnRegister()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff1 = $this->createTariffFree();
        $tariff2 = $this->createTariffTrial();

        event(new Registered($user));        
        $subscription = $user->subscription();
        $this->assertNotNull($subscription);
        $this->assertEquals($tariff1->id, $subscription->tariff_id);
    }

    public function testEndOutdatedNonprolongable()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffTrial();
        $default = $this->createTariffFree();

        Subscriptions::activate($user, $tariff);

        $subscription = $user->subscription();
        $this->assertEquals($tariff->id, $subscription->tariff_id);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Subscriptions::endOutdated();

        $subscription->refresh();
        $this->assertEquals('Ended', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($default->id, $newSubscription->tariff_id);
    }
}
