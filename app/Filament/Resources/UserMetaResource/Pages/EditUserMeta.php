<?php

namespace App\Filament\Resources\UserMetaResource\Pages;

use App\Filament\Resources\UserMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserMeta extends EditRecord
{
    protected static string $resource = UserMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
