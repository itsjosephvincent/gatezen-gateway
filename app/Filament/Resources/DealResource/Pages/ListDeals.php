<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Filament\Resources\DealResource;
use App\Jobs\SyncZohoBooks;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListDeals extends ListRecords
{
    protected static string $resource = DealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('syncDeals')
                ->label('Sync Zoho Deals')
                ->color('success')
                ->action(function (): void {
                    SyncZohoBooks::dispatch();

                    Notification::make()
                        ->title('Success')
                        ->body('Sync is now in progress.')
                        ->color('success')
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }
}
