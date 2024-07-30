<?php

namespace App\Filament\Resources\EmailTypeResource\Pages;

use App\Filament\Resources\EmailTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEmailType extends CreateRecord
{
    protected static string $resource = EmailTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
