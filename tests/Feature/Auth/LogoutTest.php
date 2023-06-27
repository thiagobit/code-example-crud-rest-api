<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\ApiTestCase;

class LogoutTest extends ApiTestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_logout_endpoint()
    {
        Auth::logout();

        $this->post(route('v1.logout'))
            ->assertUnauthorized();
    }
}
