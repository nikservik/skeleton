<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Nikservik\Subscriptions\Facades\Subscriptions;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class FeatureApiTest extends TestCase
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

    public function testFeatures()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $default = $this->createTariffFree();

        Subscriptions::activate($user, $default);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->getJson('api/auth/user')
            ->assertStatus(200)
            ->assertJsonPath('data.features', ['read-books']);
    }

    public function testAuthorizeApiFeature()
    {
        Tariff::where('id', '>', 0)->delete();
        $user = factory(User::class)->create();
        $default = $this->createTariffFree();

        Subscriptions::activate($user, $default);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->getJson('api/books')
            ->assertStatus(200)
            ->assertJsonPath('books', ['Первая книга', 'Вторая книга']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->getJson('api/money')
            ->assertStatus(403)
            ->assertJsonMissing(['money' => 1000000]);
    }
}
