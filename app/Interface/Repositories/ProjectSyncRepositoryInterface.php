<?php

namespace App\Interface\Repositories;

interface ProjectSyncRepositoryInterface
{
    public function findMany($project, $queryType);

    public function storeUsers($project, $queryType);

    public function storeShares($project, $queryType);

    public function syncTgiBankTransactions($project, $queryType);
}
