<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Nikservik\Subscriptions\Models\Tariff;
use Tests\TestCase;


class TariffControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testTariffsList()
    {
        $user = factory(User::class)->create(['role' => 3]);
        $tariffs = factory(Tariff::class, 3)->create();

        $this->actingAs($user, 'web')
            ->get('http://admin.'.Str::after(config('app.url'),'//').'/tariffs')
            ->assertStatus(200)
            ->assertSee($tariffs[2]->name)
            ->assertSee($tariffs[0]->name);
    }

    public function testTariffsShow()
    {
        $user = factory(User::class)->create(['role' => 3]);
        $tariff = factory(Tariff::class)->create();
        $tariff->features = [];
        $tariff->save();

        $this->actingAs($user, 'web')
            ->get('http://admin.'.Str::after(config('app.url'),'//').'/tariffs/'.$tariff->id)
            ->assertStatus(200)
            ->assertSee($tariff->name)
            ->assertSee($tariff->slug);
    }
}
