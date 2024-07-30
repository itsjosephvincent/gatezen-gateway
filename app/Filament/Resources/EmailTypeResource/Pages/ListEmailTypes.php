<?php

namespace App\Filament\Resources\EmailTypeResource\Pages;

use App\Filament\Resources\EmailTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmailTypes extends ListRecords
{
    protected static string $resource = EmailTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
