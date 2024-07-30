<?php

namespace App\Interface\Repositories;

use App\Models\User;

interface AuditRepositoryInterface
{
    public function store(User $user, $event, $payload);
}
