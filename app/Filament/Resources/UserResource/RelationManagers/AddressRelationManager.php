<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('street2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('postal')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('county')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('countries_id')
                    ->relationship('countries')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('addressable')
            ->columns([
                Tables\Columns\TextColumn::make('street'),
                Tables\Columns\TextColumn::make('street2'),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('postal'),
                Tables\Columns\TextColumn::make('county'),
                Tables\Columns\TextColumn::make('countries.name')
                    ->label('Country'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
