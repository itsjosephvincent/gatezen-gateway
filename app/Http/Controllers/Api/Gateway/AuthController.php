<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetForgotPasswordRequest;
use App\Interface\Services\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(AuthRequest $request)
    {
        return $this->authService->gatewayAuth($request);
    }

    public function singleSignOn(Request $request)
    {
        return $this->authService->authenticateUser($request, config('services.gateway.secret'));
    }

    public function authEncrypt(Request $request)
    {
        return $this->authService->encryptAuth($request, config('services.gateway.secret'));
    }

    public function sendForgotPasswordEmail(ForgotPasswordRequest $request)
    {
        return $this->authService->sendForgotPassword($request);
    }

    public function resetForgotPassword(ResetForgotPasswordRequest $request)
    {
        return $this->authService->resetPasswordwithToken($request);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        return $this->authService->changeUserPassword($request, $user->id);
    }

    public function signout()
    {
        $user = auth()->user();

        return $this->authService->logout($user);
    }
}
