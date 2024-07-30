<?php

namespace App\Repositories;

use App\Interface\Repositories\EntityRepositoryInterface;
use App\Models\Entity;

class EntityRepository implements EntityRepositoryInterface
{
    public function store($name, $entityType, $currentUser)
    {
        $entity = new Entity();
        $entity->user_id = $currentUser->id;
        $entity->entity_type_id = $entityType->id;
        $entity->name = $name;
        $entity->save();

        return $entity->fresh();
    }
}
