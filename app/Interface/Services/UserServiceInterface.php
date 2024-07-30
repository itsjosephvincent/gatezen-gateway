<?php

namespace App\Interface\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function getUserById(User $user);

    public function getUserByEmail(string $email);

    public function storeUser(object $payload);

    public function editUser(object $payload, User $user);

    public function editPassword(object $payload, User $user);
}
