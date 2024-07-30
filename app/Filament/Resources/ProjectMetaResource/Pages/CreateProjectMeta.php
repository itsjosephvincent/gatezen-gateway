<?php

namespace App\Filament\Resources\ProjectMetaResource\Pages;

use App\Filament\Resources\ProjectMetaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectMeta extends CreateRecord
{
    protected static string $resource = ProjectMetaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
