<?php

namespace App\Filament\Resources\DealResource\RelationManagers;

use App\Enum\Status;
use App\Enum\TransactionType;
use App\Interface\Services\DealEntryServiceInterface;
use App\Models\User;
use App\Repositories\DealEntryRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\InvoiceService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Throwable;

class DealEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'deal_entries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'firstname')
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('status')
                    ->options([
                        Status::Accepted->value => 'Accepted',
                        Status::Draft->value => 'Draft',
                        Status::Invoiced->value => 'Invoiced',
                        Status::Rejected->value => 'Rejected',
                        Status::Sent->value => 'Sent',
                    ])
                    ->default(Status::Draft->value)
                    ->required(),
                Forms\Components\TextInput::make('dealable_quantity')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('billable_price')
                    ->numeric()
                    ->inputMode('decimal'),
                Forms\Components\TextInput::make('billable_quantity')
                    ->numeric(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('metadata')
                    ->schema([
                        Forms\Components\TextInput::make('Meta data'),
                    ]),
            ]);
    }

    public function checkIfDraft($record)
    {
        if ($record->status !== Status::Draft->value) {
            return true;
        }

        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable(['firstname', 'middlename', 'lastname']),
                Tables\Columns\TextColumn::make('dealable_quantity'),
                Tables\Columns\TextColumn::make('billable_price')
                    ->numeric(
                        decimalPlaces: 4,
                        decimalSeparator: '.',
                    ),
                Tables\Columns\TextColumn::make('billable_quantity'),
                Tables\Columns\TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\Action::make('Export to Excel')
                    ->color('success')
                    ->url(function () {
                        $record = $this->getOwnerRecord();

                        return url('/user/export-deal-entries?deal_id='.$record->id);
                    }),
                Tables\Actions\Action::make('createDealEntry')
                    ->label('New deal entry')
                    ->form([
                        Forms\Components\Group::make([
                            Forms\Components\Select::make('user_id')
                                ->relationship('user', 'firstname')
                                ->required()
                                ->searchable('firstname', 'middlename', 'lastname'),
                            Forms\Components\Select::make('status')
                                ->options([
                                    Status::Accepted->value => 'Accepted',
                                    Status::Draft->value => 'Draft',
                                    Status::Invoiced->value => 'Invoiced',
                                    Status::Rejected->value => 'Rejected',
                                    Status::Sent->value => 'Sent',
                                ])
                                ->default(Status::Draft->value)
                                ->required(),
                            Forms\Components\TextInput::make('dealable_quantity')
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('billable_price')
                                ->numeric()
                                ->inputMode('decimal')
                                ->default(function () {
                                    $data = $this->getOwnerRecord();

                                    return $data->dealable->price;
                                }),
                            Forms\Components\TextInput::make('billable_quantity')
                                ->numeric(),
                            Forms\Components\Textarea::make('notes')
                                ->columnSpanFull(),
                        ])->columns(2),
                    ])
                    ->action(function ($data, DealEntryServiceInterface $dealEntryService): void {
                        try {
                            $record = $this->getOwnerRecord();
                            $payload = (object) $data;
                            $dealEntryService->createDealEntry($payload, $record);
                            Notification::make()
                                ->title('Success')
                                ->body('Successfully created a deal entry.')
                                ->color('success')
                                ->send();
                        } catch (Throwable $e) {
                            Notification::make()
                                ->title('Error')
                                ->body('An error occured while creating a deal entry.')
                                ->color('danger')
                                ->send();
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('customEdit')
                        ->label('Update')
                        ->icon('heroicon-m-pencil-square')
                        ->form([
                            Forms\Components\Group::make([
                                Forms\Components\Select::make('user_id')
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->required()
                                    ->default(function ($record) {
                                        $user = User::findOrFail($record->user_id);

                                        return $user->id;
                                    })
                                    ->searchable(),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        Status::Accepted->value => 'Accepted',
                                        Status::Draft->value => 'Draft',
                                        Status::Invoiced->value => 'Invoiced',
                                        Status::Rejected->value => 'Rejected',
                                        Status::Sent->value => 'Sent',
                                    ])
                                    ->default(Status::Draft->value)
                                    ->required(),
                                Forms\Components\TextInput::make('dealable_quantity')
                                    ->numeric()
                                    ->default(function ($record) {
                                        return $record->dealable_quantity;
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('billable_price')
                                    ->numeric()
                                    ->default(function ($record) {
                                        return $record->billable_price;
                                    })
                                    ->inputMode('decimal'),
                                Forms\Components\TextInput::make('billable_quantity')
                                    ->default(function ($record) {
                                        return $record->billable_quantity;
                                    })
                                    ->numeric(),
                                Forms\Components\Textarea::make('notes')
                                    ->default(function ($record) {
                                        return $record->notes;
                                    })
                                    ->columnSpanFull(),
                                Forms\Components\Hidden::make('metadata')
                                    ->schema([
                                        Forms\Components\TextInput::make('Meta data'),
                                    ]),
                            ])
                                ->columns(2),
                        ])
                        ->action(function (
                            $record,
                            $data,
                            DealEntryRepository $dealEntryRepository,
                            TransactionRepository $transactionRepository,
                            WalletRepository $walletRepository
                        ): void {
                            $ownerRecord = $this->getOwnerRecord();
                            $payload = (object) $data;
                            $entry = $dealEntryRepository->updateDealEntry($payload, $record->id);
                            if ($entry->status === Status::Accepted->value) {
                                $wallet = $walletRepository->store($record->user, $ownerRecord->dealable);
                                $transactionRepository->storeDealEntryTransaction($entry, $wallet, $record->dealable_quantity, TransactionType::Bought->value);
                            }
                            Notification::make()
                                ->title('Success')
                                ->body('Deal entry successfully updated.')
                                ->color('success')
                                ->send();
                        })
                        ->hidden(function ($record) {
                            return $this->checkIfDraft($record);
                        })
                        ->disabled(function ($record) {
                            return $this->checkIfDraft($record);
                        }),
                    Tables\Actions\Action::make('viewInvoice')
                        ->label('View Invoice')
                        ->icon('heroicon-m-eye')
                        ->hidden(function ($record) {
                            if (! $record->invoice_id) {
                                return true;
                            }

                            return false;
                        })
                        ->url(function ($record) {
                            $model = str_replace('App\\Models\\', '', get_class($record->invoice)).'s';
                            $slug = str_replace('_', '-', Str::snake($model));

                            return url("/admin/{$slug}/{$record->invoice->id}/edit");
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->hidden(function ($record) {
                            return $this->checkIfDraft($record);
                        })
                        ->disabled(function ($record) {
                            return $this->checkIfDraft($record);
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('UpdateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-m-pencil-square')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->options([
                                    Status::Accepted->value => 'Accept',
                                    Status::Rejected->value => 'Reject',
                                ]),
                        ])
                        ->action(function (
                            $data,
                            Collection $dealEntries,
                            DealEntryRepository $dealEntryRepository,
                            WalletRepository $walletRepository,
                            TransactionRepository $transactionRepository
                        ): void {
                            foreach ($dealEntries as $entry) {
                                $dealEntry = $dealEntryRepository->updateDealEntryStatus($entry->id, $data['status']);
                                if ($dealEntry->status === Status::Accepted->value) {
                                    $wallet = $walletRepository->findWalletByHoldableAndBelongable($dealEntry->user, $dealEntry->deal->dealable);
                                    if (! $wallet) {
                                        $wallet = $walletRepository->store($dealEntry->user, $dealEntry->deal->dealable);
                                    }
                                    $transactionRepository->storeDealEntryTransaction($entry, $wallet, $dealEntry->dealable_quantity, TransactionType::Bought->value);
                                }
                            }
                            Notification::make()
                                ->title('Success')
                                ->body('Status successfully updated.')
                                ->color('success')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('approveWallet')
                        ->label('Approve Transaction')
                        ->icon('heroicon-m-hand-thumb-up')
                        ->action(function (
                            Collection $entries,
                            TransactionRepository $transactionRepository,
                            WalletRepository $walletRepository
                        ): void {
                            foreach ($entries as $entry) {
                                foreach ($entry->transactions as $transaction) {
                                    if ($transaction->is_pending == true && $entry->status == Status::Accepted->value) {
                                        $transaction = $transactionRepository->updateDealIsPendingToFalse($entry);
                                        $walletRepository->updateWalletBalance($transaction->amount, $transaction->wallet_id);
                                    }
                                }
                            }
                            Notification::make()
                                ->title('Success')
                                ->body('Successfully approved wallet transaction.')
                                ->color('success')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('createInvoice')
                        ->label('Create an invoice')
                        ->icon('heroicon-o-receipt-percent')
                        ->action(function (Collection $entries, InvoiceService $invoiceService): void {
                            try {
                                foreach ($entries as $entry) {
                                    if ($entry->billable_price > 0 && $entry->billable_quantity > 0) {
                                        $invoiceService->createDealInvoiceForSingleEntry($entry);
                                    }
                                }
                                Notification::make()
                                    ->title('Success')
                                    ->body('Invoice successfully created for selected entries.')
                                    ->color('success')
                                    ->send();
                            } catch (Throwable $e) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('An error occured while creating invoice for selected entries.')
                                    ->color('danger')
                                    ->send();
                            }
                        }),
                ]),
            ]);
    }
}
