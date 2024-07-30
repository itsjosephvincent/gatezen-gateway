<?php

namespace App\Interface\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function authenticateUser(object $payload, string $key);

    public function encryptAuth(object $payload, string $key);

    public function gatewayAuth(object $payload);

    public function registerUser(object $payload);

    public function sendForgotPassword(object $payload);

    public function resetPasswordwithToken(object $payload);

    public function changeUserPassword(object $payload, User $user);

    public function logout(User $user);
}
