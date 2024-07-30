<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Enum\Status;
use App\Filament\Resources\DealResource;
use App\Services\InvoiceService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Throwable;

class EditDeal extends EditRecord
{
    protected static string $resource = DealResource::class;

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
                        $record->update(['status' => Status::Ongoing->value]);
                        Notification::make()
                            ->title('Success')
                            ->body('Deal successfully marked as ready.')
                            ->color('success')
                            ->send();
                        $this->redirect($this->getRedirectUrl());
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('An error occured while marking deal as ready.')
                            ->color('danger')
                            ->send();
                    }
                }),
            Actions\Action::make('createInvoice')
                ->label('Create invoice')
                ->hidden(function ($record) {
                    if ($record->status !== Status::Draft->value) {
                        return false;
                    } elseif ($record->status === Status::Invoiced->value) {
                        return true;
                    } else {
                        return true;
                    }
                })
                ->action(function ($record, InvoiceService $invoiceService): void {
                    try {
                        $invoiceService->createDealInvoice($record);
                        $this->redirect($this->getRedirectUrl());
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('An error occured while creating invoice.')
                            ->color('danger')
                            ->send();
                    }
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
}
