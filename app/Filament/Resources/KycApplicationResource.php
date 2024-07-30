<?php

namespace App\Filament\Resources;

use App\Enum\KycApplicationStatus;
use App\Filament\Resources\KycApplicationResource\Pages;
use App\Filament\Resources\KycApplicationResource\RelationManagers\KycDocumentsRelationManager;
use App\Models\KycApplication;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KycApplicationResource extends Resource
{
    protected static ?string $model = KycApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Userdata';

    protected static ?string $navigationLabel = 'KYC';

    protected static ?int $navigationSort = 23;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('application_status')
                    ->options([
                        KycApplicationStatus::Uploaded->value => 'Uploaded',
                        KycApplicationStatus::Rejected->value => 'Rejected',
                        KycApplicationStatus::Approved->value => 'Approved',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('reference')
                    ->label('Reference'),
                Forms\Components\Textarea::make('internal_note')
                    ->label('Internal note')
                    ->columnSpanFull(),
                Forms\Components\Select::make('required_docs')
                    ->multiple()
                    ->relationship('required_docs', 'name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer'),
                Tables\Columns\TextColumn::make('application_status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded at')
                    ->default(function ($record) {
                        return Carbon::parse($record->created_at)->format('M-d-Y');
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            KycDocumentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKycApplications::route('/'),
            'create' => Pages\CreateKycApplication::route('/create'),
            'view' => Pages\ViewKycApplication::route('/{record}'),
            'edit' => Pages\EditKycApplication::route('/{record}/edit'),
        ];
    }
}
