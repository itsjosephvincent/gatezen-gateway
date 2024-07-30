<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interface\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $user = auth()->user();

        return $this->userService->getUserById($user)->response();
    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        return $this->userService->editUser($request, $user)->response();
    }

    public function updatePassword(UserPasswordUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();

        return $this->userService->editPassword($request, $user)->response();
    }
}
