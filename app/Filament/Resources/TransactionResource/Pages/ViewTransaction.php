<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('uuid'),
                TextEntry::make('payable_type')
                    ->label('Payable')
                    ->color(Color::Sky)
                    ->icon('heroicon-m-eye')
                    ->iconColor(Color::Sky)
                    ->url(function ($record) {
                        $model = str_replace('App\\Models\\', '', get_class($record->payable->main)).'s';
                        $slug = str_replace('_', '-', Str::snake($model));

                        return url("/admin/{$slug}/{$record->payable->main->id}/edit");
                    }),
                TextEntry::make('wallet.uuid'),
                TextEntry::make('amount'),
                TextEntry::make('status')
                    ->default(function ($record) {
                        if ($record->is_pending == true) {
                            return 'Pending';
                        }

                        return 'Approved';
                    }),
                TextEntry::make('transaction_type'),
            ]);
    }
}
