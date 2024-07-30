<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $slug = 'wallet/transactions';

    protected static ?string $navigationLabel = 'Transactions';

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'Userdata';

    protected static ?string $navigationParentItem = 'Wallets';

    protected static ?int $navigationSort = 26;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('amount'),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\TextInput::make('transaction_type'),
                Forms\Components\TextInput::make('meta'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wallet.holdable.name')
                    ->searchable(['firstname', 'lastname', 'email']),
                Tables\Columns\TextColumn::make('payable_type'),
                Tables\Columns\TextColumn::make('transaction_type'),
                Tables\Columns\TextColumn::make('wallet.slug'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->default(function ($record) {
                        if ($record->is_pending == true) {
                            return 'Pending';
                        }

                        return 'Approved';
                    }),
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
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('markAsPending')
                        ->label('Set as pending')
                        ->icon('heroicon-m-hand-raised')
                        ->action(function ($record, TransactionRepository $transactionRepository, WalletRepository $walletRepository) {
                            $transaction = $transactionRepository->setTransactionToPending($record);
                            $walletRepository->deductWalletBalance($transaction->amount, $transaction->wallet_id);

                            return Notification::make()
                                ->title('Success')
                                ->body('Transaction successfully marked as pending.')
                                ->color('success')
                                ->send();
                        })
                        ->hidden(function ($record) {
                            if ($record->is_pending == false) {
                                return false;
                            }

                            return true;
                        }),
                    Tables\Actions\Action::make('markAskApproved')
                        ->label('Set as approved')
                        ->icon('heroicon-m-hand-thumb-up')
                        ->action(function ($record, TransactionRepository $transactionRepository, WalletRepository $walletRepository) {
                            $transaction = $transactionRepository->setTransactionToApproved($record);
                            $walletRepository->updateWalletBalance($transaction->amount, $transaction->wallet_id);

                            return Notification::make()
                                ->title('Success')
                                ->body('Transaction successfully marked as approved.')
                                ->color('success')
                                ->send();
                        })
                        ->hidden(function ($record) {
                            if ($record->is_pending == true) {
                                return false;
                            }

                            return true;
                        }),
                ]),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }
}
