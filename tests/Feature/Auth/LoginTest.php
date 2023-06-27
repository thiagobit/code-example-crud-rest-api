<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login()
    {
        $userInfo = [
            'email' => 'test@example.com',
            'password' => '12345',
        ];

        User::factory()->create($userInfo);

        $this->post(route('v1.login', $userInfo))
            ->assertSuccessful()
            ->assertSee('token');
    }

    /** @test */
    public function user_can_not_login_with_wrong_credentials()
    {
        $userInfo = [
            'email' => 'test@example.com',
            'password' => '12345',
        ];

        User::factory()->create($userInfo);

        $userInfoWithWrongEmail = [
            'email' => 'test-abc@example.com',
            'password' => $userInfo['password'],
        ];

        $this->post(route('v1.login', $userInfoWithWrongEmail))
            ->assertUnauthorized();

        $userInfoWithWrongPassword = [
            'email' => $userInfo['email'],
            'password' => '11111',
        ];

        $this->post(route('v1.login', $userInfoWithWrongPassword))
            ->assertUnauthorized();
    }
}
