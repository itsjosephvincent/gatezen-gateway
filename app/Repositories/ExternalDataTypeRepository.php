<?php

namespace App\Repositories;

use App\Interface\Repositories\ExternalDataTypeRepositoryInterface;
use App\Models\ExternalDataType;

class ExternalDataTypeRepository implements ExternalDataTypeRepositoryInterface
{
    public function showByName(string $name)
    {
        return ExternalDataType::where('name', $name)->first();
    }
}
