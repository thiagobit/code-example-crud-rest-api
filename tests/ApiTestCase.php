<?php

namespace Tests;

use App\Models\User;

abstract class ApiTestCase extends TestCase
{
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '12345',
        ]);

        $this->acceptJson();
        $this->login();
    }

    public function acceptJson()
    {
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function login()
    {
        $this->actingAs($this->user);
    }
}
