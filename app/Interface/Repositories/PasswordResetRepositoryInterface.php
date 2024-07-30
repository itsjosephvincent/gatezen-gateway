<?php

namespace App\Interface\Repositories;

interface PasswordResetRepositoryInterface
{
    public function store(string $email, string $token);

    public function findByToken(string $token);

    public function delete(string $token);
}
