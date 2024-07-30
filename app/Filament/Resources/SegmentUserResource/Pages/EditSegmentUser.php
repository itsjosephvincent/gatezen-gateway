<?php

namespace App\Filament\Resources\SegmentUserResource\Pages;

use App\Filament\Resources\SegmentUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSegmentUser extends EditRecord
{
    protected static string $resource = SegmentUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
