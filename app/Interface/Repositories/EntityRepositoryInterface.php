<?php

namespace App\Interface\Repositories;

interface EntityRepositoryInterface
{
    public function store($name, $entityType, $currentUser);
}
