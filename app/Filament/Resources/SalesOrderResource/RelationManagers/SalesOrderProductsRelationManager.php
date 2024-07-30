<?php

namespace App\Filament\Resources\SalesOrderResource\RelationManagers;

use App\Enum\Status;
use App\Interface\Services\SalesOrderProductServiceInterface;
use App\Models\Ticker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Throwable;

class SalesOrderProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'sales_order_products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MorphToSelect::make('sellable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Ticker::class)
                            ->titleAttribute('name'),
                    ])
                    ->columnSpanFull()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get): void {
                        $model = $get('sellable_type');
                        $model_id = $get('sellable_id');
                        if ($model_id) {
                            $product = $model::findOrFail($model_id);
                            $set('product_name', $product->name);
                            $set('description', $product->description ?? '');
                            $set('price', $product->price);
                        }
                    }),
                Forms\Components\TextInput::make('product_name')
                    ->label('Product name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('discount')
                    ->label('Discount')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('price')
                    ->label('Price')
                    ->numeric()
                    ->inputMode('decimal')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_name')
            ->columns([
                Tables\Columns\TextColumn::make('product_name'),
                Tables\Columns\TextColumn::make('price')
                    ->prefix(function ($record) {
                        return $record->sales_order->currency->symbol;
                    }),
                Tables\Columns\TextColumn::make('quantity'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('createAction')
                    ->label('New sales order product')
                    ->form([
                        Forms\Components\MorphToSelect::make('sellable')
                            ->types([
                                Forms\Components\MorphToSelect\Type::make(Ticker::class)
                                    ->titleAttribute('name'),
                            ])
                            ->columnSpanFull()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (callable $set, callable $get): void {
                                $model = $get('sellable_type');
                                $model_id = $get('sellable_id');
                                if ($model_id) {
                                    $product = $model::findOrFail($model_id);
                                    $set('product_name', $product->name);
                                    $set('description', $product->description ?? '');
                                    $set('price', $product->price);
                                }
                            }),
                        Forms\Components\TextInput::make('product_name')
                            ->label('Product name')
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('discount')
                            ->label('Discount')
                            ->numeric()
                            ->inputMode('decimal'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->inputMode('decimal')
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ])
                    ->action(function ($data, SalesOrderProductServiceInterface $salesOrderProductService): void {
                        try {
                            $record = $this->getOwnerRecord();
                            $payload = (object) $data;
                            $salesOrderProductService->createSalesOrderProduct($payload, $record);
                            Notification::make()
                                ->title('Success')
                                ->body('Successfully created a sales order product.')
                                ->color('success')
                                ->send();
                        } catch (Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('An error occured while creating a sales order product.')
                                ->color('danger')
                                ->send();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->disabled(function () {
                            return $this->checkIfDraft();
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->disabled(function () {
                            return $this->checkIfDraft();
                        }),
                ])->hidden(function () {
                    return $this->checkIfDraft();
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(function () {
                $record = $this->getOwnerRecord();
                if ($record->status !== Status::Draft->value) {
                    return false;
                }

                return true;
            });
    }

    public function checkIfDraft()
    {
        $record = $this->getOwnerRecord();
        if ($record->status !== Status::Draft->value) {
            return true;
        }

        return false;
    }
}
