<?php

namespace App\Repositories;

use App\Interface\Repositories\SyncRepositoryInterface;
use App\Models\Sync;

class SyncRepository implements SyncRepositoryInterface
{
    public function store($projectId, $data, $results = null)
    {
        $sync = new Sync();
        $sync->project_id = $projectId;
        $sync->data = $data;
        $sync->results = $results;
        $sync->save();

        return $sync->fresh();
    }

    public function updateResults($syncId, $results)
    {
        $sync = Sync::findOrFail($syncId);
        $sync->results = $results;
        $sync->save();

        return $sync->fresh();
    }
}
