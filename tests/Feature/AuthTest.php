<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_and_login()
    {
        $res = $this->postJson('/api/register', [
            'name' => 'User Test',
            'email' => 'user@test.com',
            'password' => 'secret123',
            'role' => 'member'
        ]);

        $res->assertStatus(201)->assertJsonStructure(['user', 'token']);

        $login = $this->postJson('/api/login', [
            'email' => 'user@test.com',
            'password' => 'secret123'
        ]);

        $login->assertStatus(200)->assertJsonStructure(['access_token', 'expires_in']);
    }
}
