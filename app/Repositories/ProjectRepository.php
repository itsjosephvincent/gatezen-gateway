<?php

namespace App\Repositories;

use App\Interface\Repositories\ProjectRepositoryInterface;
use App\Models\Project;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function findReesProjectIds()
    {
        return Project::where('name', 'REES')
            ->pluck('id');
    }

    public function findActiveProjects()
    {
        return Project::with(['tickers'])
            ->where('is_active', true)
            ->whereHas('tickers', function ($query): void {
                $query->where('is_active', true);
            })
            ->paginate(config('services.paginate.projects'));
    }

    public function findProjectById($projectId)
    {
        return Project::with(['tickers'])->findOrFail($projectId);
    }

    public function findProjectsByArrayTickerProjectIds($projectIds)
    {
        return Project::with(['tickers'])
            ->whereIn('id', $projectIds)
            ->paginate(config('services.paginate.projects'));
    }

    public function findProjectsWithWalletByUserId($sortField, $sortOrder, $projectId, $userId)
    {
        return Project::join('tickers', 'projects.id', '=', 'tickers.project_id')
            ->join('wallets', 'tickers.id', '=', 'wallets.belongable_id')
            ->select('wallets.*')
            ->where('wallets.belongable_type', 'App\Models\Ticker')
            ->where('wallets.holdable_type', 'App\Models\User')
            ->where('wallets.holdable_id', $userId)
            ->where('projects.id', $projectId)
            ->orderBy($sortField, $sortOrder)
            ->get();
    }
}
