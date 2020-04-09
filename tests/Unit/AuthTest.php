<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\AuthWithJwt;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    // use AuthWithJwt;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->create();

        $this->postJson('api/auth/login', ['email' => $user->email, 'password' => 'password'])
            ->assertStatus(200)
            ->assertHeader('Authorization');
    }

    public function testDeclineBadLogin()
    {
        $user = factory(User::class)->create();

        $this->postJson('api/auth/login', ['email' => $user->email, 'password' => 'passw'])
            ->assertStatus(401)
            ->assertHeaderMissing('Authorization')
            ->assertJson(['error' => 'login_error']);
    }

    public function testAuthorized()
    {
        $user = factory(User::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->getJson('api/auth/user')
            ->assertStatus(200)
            ->assertJsonPath('data.email', $user->email);
    }

    public function testNotAuthorized()
    {
        $this->getJson('api/auth/user')
            ->assertStatus(401);
    }

    public function testRefreshToken()
    {
        $user = factory(User::class)->create();
        $oldToken = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->getJson('api/auth/refresh')
            ->assertStatus(200)
            ->assertHeader('Authorization');

        $this->assertNotEquals($oldToken, JWTAuth::fromUser($user));
    }

    public function testLogout()
    {
        $user = factory(User::class)->create();
        $oldToken = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/auth/logout')
            ->assertStatus(200)
            ->assertHeaderMissing('Authorization');

        $this->assertNotEquals($oldToken, JWTAuth::fromUser($user));
    }
}
