<?php

namespace App\Filament\Resources\SalesOrderResource\Pages;

use App\Enum\Status;
use App\Filament\Resources\SalesOrderResource;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use App\Services\InvoiceService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;
use Throwable;

class EditSalesOrder extends EditRecord
{
    protected static string $resource = SalesOrderResource::class;

    public function getHeading(): string
    {
        $record = $this->getRecord();

        return 'Edit Sales Order #'.$record->order_number;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('markReady')
                ->label('Mark as ready')
                ->hidden(function ($record) {
                    if ($record->status !== Status::Draft->value) {
                        return true;
                    }

                    return false;
                })
                ->action(function ($record): void {
                    try {
                        $record->update(['status' => Status::Pending->value]);
                        Notification::make()
                            ->title('Success')
                            ->body('Sales order successfully marked as ready.')
                            ->color('success')
                            ->send();
                        $this->redirect($this->getRedirectUrl());
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('An error occured while marking sales order as ready.')
                            ->color('danger')
                            ->send();
                    }
                }),
            Actions\Action::make('approveTransaction')
                ->label('Approve Wallet Transaction')
                ->color('success')
                ->action(function (
                    $record,
                    WalletRepository $walletRepository,
                    TransactionRepository $transactionRepository
                ): void {
                    try {
                        foreach ($record->sales_order_products as $product) {
                            if ($product->transaction->is_pending == true) {
                                $transaction = $transactionRepository->updateSalesOrderProductIsPendingToFalse($product);
                                $walletRepository->updateWalletBalance($transaction->amount, $transaction->wallet_id);
                            }
                        }
                        Notification::make()
                            ->title('Success')
                            ->body('Wallet transaction successfully approved.')
                            ->color('success')
                            ->send();
                        $this->redirect($this->getRedirectUrl());
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('An error occured while approving wallet transaction.')
                            ->color('danger')
                            ->send();
                    }
                })
                ->hidden(function ($record) {
                    if ($record->status !== Status::Draft->value) {
                        return false;
                    }

                    return true;
                }),
            Actions\Action::make('CreateInvoice')
                ->label('Create invoice')
                ->action(function ($record, InvoiceService $invoiceService): void {
                    $invoiceService->createSalesOrderInvoice($record, $record->customer);
                    $this->redirect($this->getRedirectUrl());
                })
                ->hidden(function ($record) {
                    if ($record->status === Status::Invoiced->value) {
                        return true;
                    }

                    return false;
                }),
            Actions\Action::make('ViewInvoice')
                ->label('View invoice')
                ->url(function ($record) {
                    $model = str_replace('App\\Models\\', '', get_class($record->invoice)).'s';
                    $slug = str_replace('_', '-', Str::snake($model));

                    return url("/admin/{$slug}/{$record->invoice->id}/edit");
                })
                ->hidden(function ($record) {
                    if ($record->status === Status::Invoiced->value) {
                        return false;
                    }

                    return true;
                }),
            Actions\DeleteAction::make()
                ->hidden(function ($record) {
                    if ($record->status !== Status::Draft->value) {
                        return true;
                    }

                    return false;
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Sales order updated';
    }
}
