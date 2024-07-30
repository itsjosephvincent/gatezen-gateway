<?php

namespace App\Filament\Resources\SegmentUserResource\Pages;

use App\Filament\Resources\SegmentUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSegmentUsers extends ListRecords
{
    protected static string $resource = SegmentUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
