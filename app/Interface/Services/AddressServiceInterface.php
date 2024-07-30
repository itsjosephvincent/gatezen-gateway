<?php

namespace App\Interface\Services;

interface AddressServiceInterface
{
    public function getAddressByUserId(int $userId);
}
