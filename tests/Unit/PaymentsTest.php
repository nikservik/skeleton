<?php

namespace Tests\Unit;

use Albakov\LaravelCloudPayments\Facade as CloudPaymentsFacade;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\Facades\CloudPayments;
use Nikservik\Subscriptions\Facades\Payments;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Mail\SubscriptionActivated;
use Nikservik\Subscriptions\Mail\SubscriptionRenewed;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;

class PaymentsTest extends TestCase
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

    public function testCharge()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();

        $subscription = Subscriptions::activate($user, $tariff);
        $this->assertNotNull($subscription);
        Subscriptions::confirmActivation($subscription);
        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);

        $user->token = 'test-token';
        $user->save();
        $this->assertNotNull($subscription->user);
        $subscription->user->refresh();
        $this->assertNotNull($subscription->user->token);

        CloudPaymentsFacade::shouldReceive('tokensCharge')
            ->with(\Mockery::subset(['Amount' => $tariff->price]))
            ->with(\Mockery::subset(['Currency' => $tariff->currency]))
            ->with(\Mockery::subset(['AccountId' => $subscription->user->id]))
            ->with(\Mockery::subset(['Token' => 'test-token']))
            ->with(\Mockery::subset(['Email' => $user->email]))
            ->with(\Mockery::subset(['JsonData' => ['subscription_id' => $subscription->id, 'activation' => false]]))
            ->andReturn([
                'Model' => [
                    'Amount' => $tariff->price,
                    'Currency' => $tariff->currency,
                    'AccountId' => $subscription->user->id,
                    'Token' => 'test-token',
                    'Email' => $user->email,
                    'TransactionId' => 12345678,
                    'CardLastFour' => 1234,
                    'Status' => 'Completed',
                    'JsonData' => ['subscription_id' => $subscription->id, 'activation' => false]
                ],
                'Success' => true
            ]);

        $result = (boolean) Payments::charge($subscription);
        $this->assertTrue($result);
        $this->assertEquals(1, $subscription->payments()->count());
        $payment = $subscription->payments[0];
        $this->assertEquals($user->id, $payment->user_id);
    }

    public function testFirstPaymentConfirmation()
    {
        Mail::fake();

        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Subscriptions::activateDefault($user);
        $subscription = Subscriptions::activate($user, $tariff);
        $subscription->refresh();
        $this->assertEquals('Awaiting', $subscription->status);

        $request = new Request;
        $request->setMethod('POST');
        $request->merge([
            'AccountId' => $user->id, 
            'TransactionId' => 12345678, 
            'CardLastFour' => 1234,
            'Amount' => $tariff->price, 
            'Currency' => $tariff->currency, 
            'Status' => 'Completed', 
            'Token' => 'test-token',
            'Data' => json_encode([
                'subscription_id' => $subscription->id,
                'activation' => true,
            ])
        ]);

        CloudPayments::shouldReceive('validateSecrets')->once()->andReturn(true);

        Payments::processPaymentConfirmation($request);
        $this->assertEquals(1, $subscription->payments()->count());
        $payment = $subscription->payments[0];
        $this->assertEquals(12345678, $payment->remote_transaction_id);

        $subscription->refresh();
        $this->assertEquals('Active', $subscription->status);
        $user->refresh();
        $this->assertEquals('test-token', $user->token);
        Mail::assertQueued(SubscriptionActivated::class, 1);
    }

    public function testFirstPaymentConfirmationWithoutSubscriptionId()
    {
        Mail::fake();

        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();
        $default = $this->createTariffFree();

        Subscriptions::activateDefault($user);

        $request = new Request;
        $request->setMethod('POST');
        $request->merge([
            'AccountId' => $user->id, 
            'TransactionId' => 12345678, 
            'CardLastFour' => 1234,
            'Amount' => $tariff->price, 
            'Currency' => $tariff->currency, 
            'Status' => 'Completed', 
            'Token' => 'test-token',
            'Data' => json_encode([
                'tariff_id' => $tariff->id,
                'activation' => true,
            ])
        ]);

        CloudPayments::shouldReceive('validateSecrets')->once()->andReturn(true);

        Payments::processPaymentConfirmation($request);
        $user->refresh();
        $this->assertEquals(1, $user->subscription()->payments()->count());
        $payment = $user->subscription()->payments[0];
        $this->assertEquals(12345678, $payment->remote_transaction_id);

        $this->assertEquals($tariff->id, $user->subscription()->tariff_id);
        $user->refresh();
        $this->assertEquals('test-token', $user->token);
        Mail::assertQueued(SubscriptionActivated::class, 1);
    }
}
