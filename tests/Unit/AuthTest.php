<?php

namespace Tests\Unit;

use App\Services\AuthService;
use Mockery\MockInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Api\V1\AuthController;
use Request;
use Validator;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    protected $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = new AuthService();
    }
    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function test_signin_validation_email_required_failure()
    {
        $request = Request::create('/signin', 'POST', [
            'email' => '',
            'password' => 'password',
        ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|min:4',
        ]);
        $this->assertTrue($validator->fails());
        $response = (new AuthController())->signin($request);
        $this->assertArrayHasKey('errors', $response->original['data']);
    }
    public function test_signin_validation_password_required_failure()
    {
        $request = Request::create('/signin', 'POST', [
            'email' => 'test@test.com',
            'password' => '',
        ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|min:4',
        ]);
        $this->assertTrue($validator->fails());
        $response = (new AuthController())->signin($request);
        $this->assertArrayHasKey('errors', $response->original['data']);
    }

    public function test_signin_validation_password_min4_failure()
    {
        $request = Request::create('/signin', 'POST', [
            'email' => 'test@test.com',
            'password' => 'pas',
        ]);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|min:4',
        ]);
        $this->assertTrue($validator->fails());
        $response = (new AuthController())->signin($request);
        $this->assertArrayHasKey('errors', $response->original['data']);
    }

    public function test_signin_authentication_failure()
    {
        $request = Request::create('/signin', 'POST', [
            'email' => 'test@test.com',
            'password' => 'wrongpassword',
        ]);
        $response = (new AuthController())->signin($request);
        $this->assertEquals(404, $response->status());
    }
}
