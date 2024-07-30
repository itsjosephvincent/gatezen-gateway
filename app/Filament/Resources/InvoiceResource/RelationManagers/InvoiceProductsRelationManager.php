<?php

namespace App\Filament\Resources\InvoiceResource\RelationManagers;

use App\Enum\Status;
use App\Models\DealEntry;
use App\Models\SalesOrderProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'invoice_products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('invoiceable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(SalesOrderProduct::class)
                            ->titleAttribute('product_name'),
                        Forms\Components\MorphToSelect\Type::make(DealEntry::class)
                            ->getOptionLabelFromRecordUsing(fn (DealEntry $record): string => "{$record->deal->name}"),
                    ])
                    ->columnSpanFull(),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name'),
                Forms\Components\TextInput::make('product_name')
                    ->label('Product name')
                    ->readOnly(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric(),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->inputMode('decimal'),
            ]);
    }

    public function checkIfDraft($record)
    {
        if ($record && $record->invoice->status !== Status::Draft->value) {
            return true;
        }

        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('price')
                    ->numeric(decimalPlaces: 2, decimalSeparator: '.', thousandsSeparator: ',')
                    ->prefix(function ($record) {
                        return $record->invoice->currency->symbol;
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->disabled(function ($record) {
                            return $this->checkIfDraft($record);
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->disabled(function ($record) {
                            return $this->checkIfDraft($record);
                        }),
                ])->hidden(function ($record) {
                    return $this->checkIfDraft($record);
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(function ($record) {
                if ($record->invoice->status !== Status::Draft->value) {
                    return false;
                }

                return true;
            });
    }
}
