<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Nikservik\Subscriptions\Facades\CloudPayments;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;


class CloudPaymentsControllerTest extends TestCase
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

    public function testProcessConfirmation()
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

        CloudPayments::shouldReceive('validateSecrets')->once()->andReturn(true);

        $this->post('/api/cp/pay', [
            'AccountId' => $user->id, 
            'TransactionId' => 12345678, 
            'CardLastFour' => 1234,
            'Amount' => $tariff->price, 
            'Currency' => $tariff->currency, 
            'Status' => 'Completed', 
            'Token' => 'test-token',
            'InvoiceId' => $subscription->id,
        ])  ->assertStatus(200)
            ->assertJsonPath('code', 0);

        $this->assertEquals(1, $subscription->payments()->count());
        $payment = $subscription->payments[0];
        $this->assertEquals(12345678, $payment->remote_transaction_id);
    }
}
