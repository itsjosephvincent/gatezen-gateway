<?php

namespace App\Http\Controllers\Api\Rees;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Interface\Services\UserServiceInterface;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = $this->currentUser();

        return $this->successResponse($this->userService->getUserById($user));
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $this->currentUser();

        return $this->successResponse($this->userService->editUser($request, $user));
    }

    private function currentUser()
    {
        return auth()->user();
    }
}
