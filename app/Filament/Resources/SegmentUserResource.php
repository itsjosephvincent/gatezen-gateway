<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SegmentUserResource\Pages;
use App\Models\Segment;
use App\Models\SegmentUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SegmentUserResource extends Resource
{
    protected static ?string $model = SegmentUser::class;

    protected static ?string $slug = 'segment/users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Userdata';

    protected static ?string $navigationParentItem = 'Segments';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'id')
                    ->required(),
            ]);
    }

    public function segments()
    {
        return Segment::all();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('segment.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SpatieTagsColumn::make('user.tags')
                    ->label('Tags'),
                Tables\Columns\TextColumn::make('user.language.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('segment')->relationship('segment', 'name'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('exportSegmentUsers')
                    ->label('Export Segment Users to Excel')
                    ->color('success')
                    ->url(function () {
                        return url('/user/export-segment-users');
                    }),
            ])
            ->actions([
                //
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
            'index' => Pages\ListSegmentUsers::route('/'),
            'create' => Pages\CreateSegmentUser::route('/create'),
            'edit' => Pages\EditSegmentUser::route('/{record}/edit'),
        ];
    }
}
