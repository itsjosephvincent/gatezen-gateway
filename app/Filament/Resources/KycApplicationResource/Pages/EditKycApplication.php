<?php

namespace App\Filament\Resources\KycApplicationResource\Pages;

use App\Filament\Resources\KycApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKycApplication extends EditRecord
{
    protected static string $resource = KycApplicationResource::class;

    public function getHeading(): string
    {
        $record = $this->getRecord();

        return $record->user->name."'s KYC Application";
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }
}
