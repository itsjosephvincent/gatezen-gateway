<?php

namespace App\Interface\Services;

interface DealServiceInterface
{
    public function getAllUserDealsByUserId(int $userId);
}
