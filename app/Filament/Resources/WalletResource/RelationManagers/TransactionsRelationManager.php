<?php

namespace App\Filament\Resources\WalletResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('wallet_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('wallet_id')
            ->columns([
                Tables\Columns\TextColumn::make('wallet.belongable.name')
                    ->label('Assets'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Transaction amount'),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->label('Transaction Type'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Transaction date'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->default(function ($record) {
                        if ($record->is_pending == true) {
                            return 'Pending';
                        }

                        return 'Approved';
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
