<?php

namespace App\Repositories;

use App\Interface\Repositories\AuditRepositoryInterface;
use App\Models\Audit;
use App\Models\User;

class AuditRepository implements AuditRepositoryInterface
{
    public function store(User $user, $event, $payload)
    {
        $audit = new Audit();
        $audit->user_type = get_class($user);
        $audit->user_id = $user->id;
        $audit->event = $event;
        $audit->auditable_type = get_class($user);
        $audit->auditable_id = $user->id;
        $audit->ip_address = $payload->ip();
        $audit->save();

        return $audit->fresh();
    }
}
