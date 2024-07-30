<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoicePaymentResource\Pages;
use App\Models\InvoicePayment;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoicePaymentResource extends Resource
{
    protected static ?string $model = InvoicePayment::class;

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationParentItem = 'Invoices';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice.invoice_number')
                    ->label('Invoice number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('balance'),
                Tables\Columns\TextColumn::make('currency.name'),
                Tables\Columns\TextColumn::make('invoice.status')
                    ->label('Invoice status'),
                Tables\Columns\TextColumn::make('payment_date')
                    ->searchable(),
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
            'index' => Pages\ListInvoicePayments::route('/'),
            'create' => Pages\CreateInvoicePayment::route('/create'),
            'edit' => Pages\EditInvoicePayment::route('/{record}/edit'),
        ];
    }
}
