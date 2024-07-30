<?php

namespace App\Filament\Resources\ProjectMetaResource\Pages;

use App\Filament\Resources\ProjectMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectMeta extends EditRecord
{
    protected static string $resource = ProjectMetaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
