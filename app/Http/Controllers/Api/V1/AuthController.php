<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    protected $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|min:4',
        ]);

        // validation
        if ($validator->fails()) {
            return $this->onFailed(tr_uc('app.failed_signin'), [
                'errors' => $validator->errors()
            ]);
        }

        $credentials = $request->only('email', 'password');
        if (!$this->authService->login($credentials)) {
            return $this->onFailed(tr_uc('app.failed_signin'));
        }

        $user = auth()->user();
        $token = $user->createToken('API Token')->plainTextToken;

        return $this->onSuccess(tr('app.success_signin', ['message' => '']), [
            'token_type' => 'Bearer',
            'token' => $token,
        ]);

    }
}
