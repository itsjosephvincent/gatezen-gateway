<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Interface\Services\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function authenticate(Request $request)
    {
        return $this->authService->authenticateUser($request, config('services.rees.secret'));
    }

    public function register(UserRegistrationRequest $request)
    {
        return $this->authService->registerUser($request);
    }

    public function authEncrypt(Request $request)
    {
        return $this->authService->encryptAuth($request, config('services.rees.secret'));
    }

    public function logout()
    {
        $user = auth()->user();

        return $this->authService->logout($user);
    }
}
