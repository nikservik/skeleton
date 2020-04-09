<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserLocaleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetDefaultLocale()
    {
        $user = factory(User::class)->create();

        $this->assertEquals($this->app->getLocale(), $user->locale);
    }

    public function testSetGetLocale()
    {
        $user = factory(User::class)->create();

        $this->assertNotEquals('en', $user->locale);
        $user->locale = 'en';
        $this->assertEquals('en', $user->locale);
    }

    public function testDontSetBadLocale()
    {
        $user = factory(User::class)->create();

        $user->locale = 'jj';
        $this->assertNotEquals('jj', $user->locale);
    }

    public function testApiStoreLocale()
    {
        $user = factory(User::class)->create();

        $this->assertNotEquals('en', $user->locale);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/locale', ['locale' => 'en'])
            ->assertStatus(200);

        $user->refresh();
        $this->assertEquals('en', $user->locale);
    }
}
