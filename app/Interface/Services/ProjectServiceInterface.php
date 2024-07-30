<?php

namespace App\Interface\Services;

interface ProjectServiceInterface
{
    public function getActiveProjects();

    public function getProjectById(int $projectId);

    public function getProjectsWithWalletByUserId(int $projectId, $user);

    public function getProjectsByUserId(int $userId);
}
