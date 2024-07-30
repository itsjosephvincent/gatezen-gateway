<?php

namespace App\Interface\Repositories;

interface SyncRepositoryInterface
{
    public function store($projectId, $data, $results = null);

    public function updateResults($syncId, $results);
}
