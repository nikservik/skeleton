<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;


class ProfileEditTest extends TestCase
{
    use DatabaseTransactions;

    public function testSaveName()
    {
        $user = factory(User::class)->create(['name' => 'Lee Cooper']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/name', ['name' => 'John Woo'])
            ->assertStatus(200);

        $user->refresh();
        $this->assertEquals('John Woo', $user->name);
    }

    public function testSaveNameUnauthorized()
    {
        $user = factory(User::class)->create(['name' => 'Lee Cooper']);

        $this->postJson('api/user/name', ['name' => 'John Woo'])
            ->assertStatus(401);

        $user->refresh();
        $this->assertEquals('Lee Cooper', $user->name);
    }

    public function testSaveNameIncorrect()
    {
        $user = factory(User::class)->create(['name' => 'Lee Cooper']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/name', ['name' => 'Jo'])
            ->assertStatus(422);

        $user->refresh();
        $this->assertEquals('Lee Cooper', $user->name);
    }

    public function testSavePassword()
    {
        $user = factory(User::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/password', [
                'old_password' => 'password',
                'password' => 'newpassword', 
                'password_confirmation' => 'newpassword',
            ])
            ->assertStatus(200);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword', $user->password));
    }

    public function testSavePasswordUnauthorized()
    {
        $user = factory(User::class)->create();

        $this->postJson('api/user/password', [
                'old_password' => 'password',
                'password' => 'newpassword', 
                'password_confirmation' => 'newpassword',
            ])
            ->assertStatus(401);

        $user->refresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function testSavePasswordIncorrect()
    {
        $user = factory(User::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/password', [
                'old_password' => 'badpassword',
                'password' => 'new', 
                'password_confirmation' => 'passwordnew',
            ])
            ->assertStatus(422)
            ->assertJsonPath('errors.password', ['password.min', 'password.confirmed'])
            ->assertJsonPath('errors.old_password', ['old_password.password']);

        $user->refresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function testSavePasswordWithoutOldPassword()
    {
        $user = factory(User::class)->create();

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/password', [
                'password' => 'newpassword', 
                'password_confirmation' => 'newpassword',
            ])
            ->assertStatus(422);

        $user->refresh();
        $this->assertTrue(Hash::check('password', $user->password));
    }
    public function testSaveEmail()
    {
        $user = factory(User::class)->create(['email' => 'test1@example.com']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/email', ['email' => 'new@example.com'])
            ->assertStatus(200);

        $user->refresh();
        $this->assertEquals('new@example.com', $user->email);
    }

    public function testSaveEmailUnauthorized()
    {
        $user = factory(User::class)->create(['email' => 'test2@example.com']);

        $this->postJson('api/user/email', ['email' => 'new@example.com'])
            ->assertStatus(401);

        $user->refresh();
        $this->assertEquals('test2@example.com', $user->email);
    }

    public function testSaveEmailIncorrect()
    {
        $user = factory(User::class)->create(['email' => 'test3@example.com']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user)])
            ->postJson('api/user/email', ['email' => 'bad@example'])
            ->assertStatus(422);

        $user->refresh();
        $this->assertEquals('test3@example.com', $user->email);
    }

    public function testSaveEmailNotUnique()
    {
        $user1 = factory(User::class)->create(['email' => 'test4@example.com']);
        $user2 = factory(User::class)->create(['email' => 'used@example.com']);

        $this->withHeaders(['Authorization' => 'Bearer '.JWTAuth::fromUser($user1)])
            ->postJson('api/user/email', ['email' => 'used@example.com'])
            ->assertStatus(422);

        $user1->refresh();
        $this->assertEquals('test4@example.com', $user1->email);
    }

}
