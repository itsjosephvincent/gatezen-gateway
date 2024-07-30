<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class WalletsRelationManager extends RelationManager
{
    protected static string $relationship = 'wallets';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('holdable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(User::class)
                            ->titleAttribute('email'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('slug')
            ->columns([
                Tables\Columns\TextColumn::make('holdable.name')
                    ->label('Holder'),
                Tables\Columns\TextColumn::make('belongable.name')
                    ->label('Belonging'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('balance'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewWallet')
                        ->label('View Wallet')
                        ->icon('heroicon-o-eye')
                        ->action(function ($record): void {
                            redirect("/admin/wallets/$record->id");
                        }),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
