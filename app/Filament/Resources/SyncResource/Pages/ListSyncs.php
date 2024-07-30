<?php

namespace App\Filament\Resources\SyncResource\Pages;

use App\Filament\Resources\SyncResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSyncs extends ListRecords
{
    protected static string $resource = SyncResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
