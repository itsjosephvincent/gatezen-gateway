<?php

namespace App\Filament\Resources\EmailTypeResource\Pages;

use App\Filament\Resources\EmailTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmailType extends EditRecord
{
    protected static string $resource = EmailTypeResource::class;

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
