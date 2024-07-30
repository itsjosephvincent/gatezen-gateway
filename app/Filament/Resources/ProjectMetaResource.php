<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectMetaResource\Pages;
use App\Models\ProjectMeta;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectMetaResource extends Resource
{
    protected static ?string $model = ProjectMeta::class;

    protected static ?string $slug = 'project/metas';

    protected static ?string $navigationLabel = 'Meta';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Projects';

    protected static ?string $navigationParentItem = 'Projects';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                Forms\Components\TextInput::make('field')
                    ->required()
                    ->columnStart(1),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name'),
                Tables\Columns\TextColumn::make('field'),
                Tables\Columns\TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectMetas::route('/'),
            'create' => Pages\CreateProjectMeta::route('/create'),
            'edit' => Pages\EditProjectMeta::route('/{record}/edit'),
        ];
    }
}
