<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\WalletResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class Wallets extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent updated wallets';

    public function table(Table $table): Table
    {
        return $table
            ->query(WalletResource::getEloquentQuery())
            ->defaultPaginationPageOption(3)
            ->defaultSort('updated_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('holdable.name')
                    ->label('Holder')
                    ->searchable(['firstname', 'lastname']),
                Tables\Columns\TextColumn::make('belongable.name')
                    ->label('Belonging')
                    ->searchable('name'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric(
                        decimalPlaces: 4,
                        decimalSeparator: '.',
                        thousandsSeparator: ''
                    )
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pending_balance')
                    ->numeric(
                        decimalPlaces: 4,
                        decimalSeparator: '.',
                        thousandsSeparator: ''
                    ),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
