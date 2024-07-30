<?php

namespace App\Filament\Resources\UserMetaResource\Pages;

use App\Filament\Resources\UserMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserMetas extends ListRecords
{
    protected static string $resource = UserMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
