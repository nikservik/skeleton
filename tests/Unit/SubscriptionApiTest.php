<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class SubscriptionApiTest extends TestCase
{
    use DatabaseTransactions;

    public function testList()
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

        $this->getJson('api/subscriptions')
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
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
}
