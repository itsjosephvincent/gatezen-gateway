<?php

namespace App\Filament\Resources\ProjectMetaResource\Pages;

use App\Filament\Resources\ProjectMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectMetas extends ListRecords
{
    protected static string $resource = ProjectMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
