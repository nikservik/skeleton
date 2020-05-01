<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nikservik\Subscriptions\CloudPayments\PaymentApiResponse;
use Nikservik\Subscriptions\Facades\CloudPayments;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class SubscriptionApiTest extends TestCase
{
    use DatabaseTransactions;

    public function testListAndTranslations()
    {
        Tariff::where('id', '>', 0)->delete();
        $default = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => 'endless',
        ]); 
        $default->visible = true;
        $default->save();
        $trial = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => '1 month',
        ]); 
        $paid = factory(Tariff::class)->create([
            'price' => 100,
            'prolongable' => true,
            'period' => '1 month',
        ]); 

        $this->getJson('api/subscriptions')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data.subscriptions');
        $this->getJson('api/subscriptions/translations')
            ->assertStatus(200)
            ->assertJsonCount(2, 'data.features.see-welcome')
            ->assertJsonCount(2, 'data.periods.endless');
    }

    public function testActivate()
    {
        Tariff::where('id', '>', 0)->delete();
        $default = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => 'endless',
        ]); 
        $trial = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => '1 month',
        ]); 
        $paid = factory(Tariff::class)->create([
            'price' => 100,
            'prolongable' => true,
            'period' => '1 month',
        ]); 

        $user = factory(User::class)->create();
        Subscriptions::activate($user, $default);

        $this->assertNotNull($user->subscription());
        $this->assertEquals($default->id, $user->subscription()->tariff_id);

        $this->postJson('api/subscriptions', ['tariff' => $trial->id])
            ->assertStatus(401);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/subscriptions', ['tariff' => $trial->id])
            ->assertStatus(200)
            ->assertJson(['status' => 'success'])
            ->assertJsonPath('data.subscription.tariff_id', $trial->id);

        $this->assertEquals($trial->id, $user->subscription()->tariff_id);
    }

    public function testCancel()
    {
        Tariff::where('id', '>', 0)->delete();
        $default = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => 'endless',
        ]); 
        $default->default = true;
        $default->visible = true;
        $default->save();
        $trial = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => '1 month',
        ]); 
        $paid = factory(Tariff::class)->create([
            'price' => 100,
            'prolongable' => true,
            'period' => '1 month',
        ]); 

        $user = factory(User::class)->create();
        $subscription = Subscriptions::activate($user, $paid);
        Subscriptions::confirmActivation($subscription);
        $this->assertEquals($paid->id, $user->subscription()->tariff_id);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/subscriptions/cancel')
            ->assertStatus(200)
            ->assertJson(['status' => 'success'])
            ->assertJsonPath('data.subscription.status', 'Cancelled')
            ->assertJsonPath('data.subscription.tariff_id', $paid->id);
    }


    public function testCrypt()
    {
        Tariff::where('id', '>', 0)->delete();
        $default = factory(Tariff::class)->create([
            'price' => 0,
            'prolongable' => false,
            'period' => 'endless',
        ]); 
        $paid = factory(Tariff::class)->create([
            'price' => 100,
            'prolongable' => true,
            'period' => '1 month',
        ]); 

        $user = factory(User::class)->create();
        Subscriptions::activate($user, $default);

        $this->assertNotNull($user->subscription());
        $this->assertEquals($default->id, $user->subscription()->tariff_id);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/subscriptions/crypt', [
                'tariff' => $paid->id,
                'name' => 'Cardholder',
                'crypt' => '',
            ])
            ->assertStatus(422);

        CloudPayments::shouldReceive('paymentsCardsCharge')
            ->andReturn(
                new PaymentApiResponse([
                    'Model' => [
                        'Amount' => $paid->price,
                        'Currency' => $paid->currency,
                        'AccountId' => $user->id,
                        'Token' => 'test-token',
                        'TransactionId' => 12345678,
                        'CardLastFour' => 1234,
                        'Status' => 'Completed',
                    ],
                    'Success' => true
                ])
            );

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/subscriptions/crypt', [
                'tariff' => $paid->id,
                'name' => 'Cardholder',
                'crypt' => '12345678jjjjj',
            ])
            ->assertStatus(200);

        $this->assertEquals($paid->id, $user->subscription()->tariff_id);
    }
}
