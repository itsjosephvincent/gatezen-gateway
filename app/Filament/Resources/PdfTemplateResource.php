<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PdfTemplateResource\Pages;
use App\Models\PdfTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PdfTemplateResource extends Resource
{
    protected static ?string $model = PdfTemplate::class;

    protected static ?string $slug = 'pdf-templates';

    protected static ?string $navigationLabel = 'PDF Templates';

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Projects';

    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name'),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('html_template')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->options([
                        'creditnote' => 'Creditnote',
                        'deal' => 'Deal',
                        'invoice' => 'Invoice',
                        'portfolio' => 'Portfolio',
                        'sale' => 'Sale',
                    ])
                    ->required(),
                Forms\Components\Repeater::make('pdf_settings')
                    ->schema([
                        Forms\Components\TextInput::make('settings'),
                    ]),
                Forms\Components\Toggle::make('is_default')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('project.name'),
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
            'index' => Pages\ListPdfTemplates::route('/'),
            'create' => Pages\CreatePdfTemplate::route('/create'),
            'edit' => Pages\EditPdfTemplate::route('/{record}/edit'),
        ];
    }
}
