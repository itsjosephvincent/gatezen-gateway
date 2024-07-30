<?php

namespace App\Filament\Resources\ActivityLogResource\Pages;

use App\Filament\Resources\ActivityLogResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewActivityLog extends ViewRecord
{
    protected static string $resource = ActivityLogResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('subject_type')
                    ->label('Model'),
                TextEntry::make('subject_id')
                    ->label('Model ID'),
                TextEntry::make('causer.name')
                    ->label('Causer'),
                TextEntry::make('created_at')
                    ->label('Activity Date'),
                TextEntry::make('description')
                    ->label('Activity description')
                    ->columnSpanFull(),
            ]);
    }
}
