<?php

namespace Tests\Unit;

use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\CloudPayments\PaymentApiResponse;
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

        CloudPayments::shouldReceive('paymentsTokensCharge')
            ->andReturn(
                new PaymentApiResponse([
                    'Model' => [
                        'Amount' => $tariff->price,
                        'Currency' => $tariff->currency,
                        'AccountId' => $subscription->user->id,
                        'InvoiceId' => $subscription->id,
                        'Token' => 'test-token',
                        'Email' => $user->email,
                        'TransactionId' => 12345678,
                        'CardLastFour' => 1234,
                        'Status' => 'Completed',
                    ],
                    'Success' => true
                ])
            );

        $result = (boolean) Payments::charge($subscription);
        $this->assertTrue($result);
        $this->assertEquals(1, $subscription->payments()->count());
        $payment = $subscription->payments[0];
        $this->assertEquals($user->id, $payment->user_id);
    }


    public function testChargeByCrypt()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();

        CloudPayments::shouldReceive('paymentsCardsCharge')
            ->andReturn(
                new PaymentApiResponse([
                    'Model' => [
                        'Amount' => $tariff->price,
                        'Currency' => $tariff->currency,
                        'AccountId' => $user->id,
                        'Token' => 'test-token',
                        'TransactionId' => 12345678,
                        'CardLastFour' => 1234,
                        'Status' => 'Completed',
                    ],
                    'Success' => true
                ])
            );

        $result = (boolean) Payments::chargeByCrypt($user, $tariff, 'Cardholder', '127.0.0.1', '123456787654321');
        $this->assertTrue($result);
        $this->assertEquals(1, $user->subscription()->payments()->count());
        $payment = $user->subscription()->payments[0];
        $this->assertEquals($user->id, $payment->user_id);
    }

    public function testChargeByCryptNeed3dSecure()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();

        CloudPayments::shouldReceive('paymentsCardsCharge')
            ->andReturn(
                new PaymentApiResponse([
                    'Model' => [
                        'TransactionId' => 12345678,
                        'PaReq' => '876543212345678',
                        'AcsUrl' => 'http://somewhere.com/to',
                    ],
                    'Success' => false
                ])
            );

        $result = Payments::chargeByCrypt($user, $tariff, 'Cardholder', '127.0.0.1', '123456787654321');
        $this->assertTrue(is_array($result));
        $this->assertEquals(12345678, $result['TransactionId']);
        $this->assertEquals('876543212345678', $result['PaReq']);
        $this->assertEquals('http://somewhere.com/to', $result['AcsUrl']);
    }

    public function testChargeByCryptDeclined()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        $tariff = $this->createTariffPaid();

        CloudPayments::shouldReceive('paymentsCardsCharge')
            ->andReturn(
                new PaymentApiResponse([
                    'Model' => [
                        'TransactionId' => 12345678,
                        'ReasonCode' => 5001,
                        'Reason' => 'No',
                    ],
                    'Success' => false
                ])
            );

        $result = Payments::chargeByCrypt($user, $tariff, 'Cardholder', '127.0.0.1', '123456787654321');
        $this->assertTrue(is_string($result));
    }
}
