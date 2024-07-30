<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Interface\Services\ProjectServiceInterface;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    private $projectService;

    public function __construct(ProjectServiceInterface $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(): JsonResponse
    {
        return $this->projectService->getActiveProjects()->response();
    }

    public function show($projectId): JsonResponse
    {
        return $this->projectService->getProjectById($projectId)->response();
    }

    public function showProjectWalletById($projectId): JsonResponse
    {
        $user = auth()->user();

        return $this->projectService->getProjectsWithWalletByUserId($projectId, $user)->response();
    }

    public function showProjectsByUserId(): JsonResponse
    {
        $user = auth()->user();

        return $this->projectService->getProjectsByUserId($user->id)->response();
    }
}
