<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletResource\Pages;
use App\Filament\Resources\WalletResource\RelationManagers\TransactionsRelationManager;
use App\Models\Ticker;
use App\Models\User;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\ExchangeService;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $slug = 'wallets';

    protected static ?string $navigationLabel = 'Wallets';

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $navigationGroup = 'Userdata';

    protected static ?int $navigationSort = 21;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\MorphToSelect::make('holdable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(User::class)
                            ->titleAttribute('email'),
                    ])
                    ->required(),
                Forms\Components\MorphToSelect::make('belongable')
                    ->types([
                        Forms\Components\MorphToSelect\Type::make(Ticker::class)
                            ->titleAttribute('name'),
                    ])
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\TextInput::make('meta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('holdable.name')
                    ->label('Holder')
                    ->searchable(['firstname', 'lastname']),
                Tables\Columns\TextColumn::make('belongable.name')
                    ->label('Belonging')
                    ->searchable('name'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->numeric(
                        decimalPlaces: 4,
                        decimalSeparator: '.',
                        thousandsSeparator: ''
                    )
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pending_balance')
                    ->numeric(
                        decimalPlaces: 4,
                        decimalSeparator: '.',
                        thousandsSeparator: ''
                    ),
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
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Sell assets')
                        ->label('Sell assets')
                        ->icon('heroicon-o-minus-circle')
                        ->form([
                            TextInput::make('asset')
                                ->label('Asset')
                                ->default(function ($record) {
                                    return $record->belongable->name;
                                })
                                ->disabled(),
                            Hidden::make('wallet_id')
                                ->default(function ($record) {
                                    return $record->id;
                                }),
                            TextInput::make('shares')
                                ->label('Amount in shares')
                                ->numeric()
                                ->default(function ($record) {
                                    return $record->balance;
                                })
                                ->required(),
                            DateTimePicker::make('timestamp')
                                ->label('Transaction timestamp')
                                ->default(now())
                                ->displayFormat('d/m/Y H:i:s')
                                ->native(false)
                                ->required(),
                        ])->action(function (array $data, ExchangeService $exchangeService) {
                            $validator = $exchangeService->validateData($data);
                            if ($validator->fails()) {
                                return Notification::make()
                                    ->title('Error')
                                    ->body('The amount shares you entered is invalid.')
                                    ->color('danger')
                                    ->send();
                            }
                            $exchange = $exchangeService->sell($data);

                            if ($exchange === false) {
                                return Notification::make()
                                    ->title('Error')
                                    ->body('The amount shares you entered is invalid.')
                                    ->color('danger')
                                    ->send();
                            }

                            return Notification::make()
                                ->title('Success')
                                ->body('Assets successfully sold.')
                                ->color('success')
                                ->send();
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('refreshBalance')
                        ->label('Refresh Balance')
                        ->icon('heroicon-m-arrow-path')
                        ->action(function (
                            Collection $wallets,
                            TransactionRepository $transactionRepository,
                            WalletRepository $walletRepository
                        ): void {
                            try {
                                foreach ($wallets as $wallet) {
                                    $approved = $transactionRepository->findSumOfTransactionApprovedBalanceByWalletId($wallet->id);
                                    if ($wallet->balance != $approved) {
                                        $walletRepository->refreshWalletBalance($approved, $wallet->id);
                                    }
                                }
                                Notification::make()
                                    ->title('Success')
                                    ->body('Balance successfully refreshed')
                                    ->color('success')
                                    ->send();
                            } catch (Throwable $e) {
                                Log::debug($e);
                            }
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            'view' => Pages\ViewWallet::route('/{record}'),
        ];
    }
}
