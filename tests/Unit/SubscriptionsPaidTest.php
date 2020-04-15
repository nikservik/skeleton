<?php

namespace Tests\Unit;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\Facades\Payments;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Mail\SubscriptionAboutToRenew;
use Nikservik\Subscriptions\Mail\SubscriptionActivated;
use Nikservik\Subscriptions\Mail\SubscriptionCancelled;
use Nikservik\Subscriptions\Mail\SubscriptionEnded;
use Nikservik\Subscriptions\Mail\SubscriptionPastDue;
use Nikservik\Subscriptions\Mail\SubscriptionRejected;
use Nikservik\Subscriptions\Mail\SubscriptionRenewed;
use Nikservik\Subscriptions\Models\Tariff;
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
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Subscriptions::activateDefault($user);
        $defaultSubscription = $user->subscription();
        $this->assertEquals($default->id, $defaultSubscription->tariff_id);

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        $this->assertEquals($tariff->id, $subscription->tariff_id);
        $this->assertEquals('Awaiting', $subscription->status);

        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($tariff->id, $newSubscription->tariff_id);

        Mail::assertQueued(SubscriptionActivated::class, 1);
    }


    public function testCancelPaid()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Subscriptions::activateDefault($user);
        $defaultSubscription = $user->subscription();
        $this->assertEquals($default->id, $defaultSubscription->tariff_id);

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        $this->assertEquals('Awaiting', $subscription->status);

        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        Subscriptions::cancel($subscription);
        $subscription->refresh();
        $this->assertEquals('Cancelled', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Subscriptions::endCancelled();
        $subscription->refresh();
        $this->assertEquals('Ended', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($default->id, $newSubscription->tariff_id);
        Mail::assertQueued(SubscriptionCancelled::class, 1);
        Mail::assertQueued(SubscriptionEnded::class, 1);
    }


    public function testChargePaid()
    {
        Mail::fake();

        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Payments::shouldReceive('charge')
                    ->once()
                    ->andReturn(true);
        Subscriptions::chargePaid(); // оплата прошла
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);
        $this->assertEquals(Carbon::now()->sub('1 day')->add($tariff->period)->format('d.m.Y'), $subscription->next_transaction_date->format('d.m.Y'));
        Mail::assertQueued(SubscriptionRenewed::class, 1);
    }

    public function testChargePaidDeclined()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = Carbon::now()->sub('1 day');
        $subscription->save();

        Payments::shouldReceive('charge')
                    ->once()
                    ->andReturn(false);
        Subscriptions::chargePaid(); // оплата не прошла
        $subscription->refresh();
        $this->assertEquals('PastDue', $subscription->status);
        $this->assertNotEquals(Carbon::now()->add($tariff->period)->format('d.m.Y'), $subscription->next_transaction_date->format('d.m.Y'));
        Mail::assertQueued(SubscriptionPastDue::class, 1);
    }

    public function testRejectPastDue()
    {
        Mail::fake();
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $subscription->next_transaction_date = 
            Carbon::now()->sub('1 day')->sub(config('subscriptions.past_due.reject'));
        $subscription->save();

        Payments::shouldReceive('charge')
                    ->once()
                    ->andReturn(false);
        Subscriptions::chargePaid(false); // оплата давно не прошла
        $subscription->refresh();
        $this->assertEquals('Rejected', $subscription->status);

        $newSubscription = $user->subscription();
        $this->assertNotNull($newSubscription);
        $this->assertEquals($default->id, $newSubscription->tariff_id);
        Mail::assertQueued(SubscriptionRejected::class, 1);
    }

    public function testWarnBeforeCharge()
    {
        Mail::fake();
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        $tariff = $this->createTariffPaid();

        $subscription1 = Subscriptions::activate($user1, $tariff);
        Subscriptions::confirmActivation($subscription1);
        $subscription1->refresh();

        $subscription2 = Subscriptions::activate($user2, $tariff);
        Subscriptions::confirmActivation($subscription2);
        $subscription2->refresh();

        $subscription3 = Subscriptions::activate($user3, $tariff);
        Subscriptions::confirmActivation($subscription3);
        $subscription3->refresh();

        $subscription1->next_transaction_date = 
            Carbon::now()->add(config('subscriptions.before_charge.before'))->sub('1 day');
        $subscription1->save();

        $subscription2->next_transaction_date = 
            Carbon::now()->add(config('subscriptions.before_charge.before'));
        $subscription2->save();

        $subscription3->next_transaction_date = 
            Carbon::now()->add(config('subscriptions.before_charge.before'))->add('1 day');
        $subscription3->save();

        Subscriptions::warnBeforeCharge();
        Mail::assertQueued(SubscriptionAboutToRenew::class, 1);
    }
}
