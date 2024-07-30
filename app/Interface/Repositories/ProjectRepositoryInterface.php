<?php

namespace App\Interface\Repositories;

interface ProjectRepositoryInterface
{
    public function findReesProjectIds();

    public function findActiveProjects();

    public function findProjectById(int $projectId);

    public function findProjectsWithWalletByUserId(string $sortField, string $sortOrder, int $projectId, int $userId);

    public function findProjectsByArrayTickerProjectIds(array $projectIds);
}
