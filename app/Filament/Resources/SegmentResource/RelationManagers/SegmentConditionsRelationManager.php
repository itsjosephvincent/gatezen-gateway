<?php

namespace App\Filament\Resources\SegmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SegmentConditionsRelationManager extends RelationManager
{
    protected static string $relationship = 'segment_conditions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('model_type')
                    ->required()
                    ->options([
                        'Language' => 'Language',
                        'Project' => 'Project',
                        'Tags' => 'Tags',
                        'Ticker' => 'Ticker',
                    ])
                    ->preload(),
                Forms\Components\TextInput::make('field')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('operator')
                    ->required()
                    ->options([
                        '=' => '=',
                        '<' => '<',
                        '>' => '>',
                        '<=' => '<=',
                        '>=' => '>=',
                        '<>' => '<>',
                        '!=' => '!=',
                        'EXISTS' => 'EXISTS',
                        'IN' => 'IN',
                        'LIKE' => 'LIKE',
                        'NOT LIKE' => 'NOT LIKE',
                    ])
                    ->preload(),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('segment_id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('segment_id'),
                Tables\Columns\TextColumn::make('model_type'),
                Tables\Columns\TextColumn::make('field'),
                Tables\Columns\TextColumn::make('operator'),
                Tables\Columns\TextColumn::make('value'),
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
