<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_signin_validation_email_failure()
    {
        $response = $this->postJson('/api/v1/signin', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'errors' => [
                    'email' => []
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'email' => ['The email field is required.']
        ]);
    }

    public function test_signin_validation_password_failure()
    {
        $response = $this->postJson('/api/v1/signin', [
            'email' => 'test@test.com',
            'password' => '',
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'errors' => [
                    'password' => []
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'password' => ['The password field is required.']
        ]);
    }

    public function test_signin_validation_password_min4_failure()
    {
        $response = $this->postJson('/api/v1/signin', [
            'email' => 'test@test.com',
            'password' => 'w',
        ]);

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'data' => [
                'errors' => [
                    'password' => []
                ]
            ]
        ]);
        $response->assertJsonFragment([
            'password' => ['The password field must be at least 4 characters.']
        ]);
    }
}
