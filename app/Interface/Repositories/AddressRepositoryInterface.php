<?php

namespace App\Interface\Repositories;

use App\Models\User;

interface AddressRepositoryInterface
{
    public function findAddressByUser(User $user);

    public function updateAddress(object $payload, User $user);

    public function storeAddress(object $payload, User $user);
}
