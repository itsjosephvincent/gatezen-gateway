<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Enum\Status;
use App\Filament\Resources\InvoiceResource;
use App\Mail\SendInvoiceEmail;
use App\Repositories\InvoicePaymentRepository;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    public function getHeading(): string
    {
        $record = $this->getRecord();

        return 'Edit Invoice #'.$record->invoice_number;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('addPayment')
                ->label('New Invoice Payment')
                ->form([
                    TextInput::make('amount')
                        ->numeric()
                        ->inputMode('decimal')
                        ->required(),
                    Select::make('currency_id')
                        ->relationship('currency', 'name')
                        ->required(),
                    DatePicker::make('payment_date'),
                    Textarea::make('description'),
                    TextInput::make('reference')
                        ->required(),
                    Select::make('payment_type')
                        ->options([
                            'cash' => 'Cash',
                            'bank_transfer' => 'Bank transfer',
                        ])
                        ->required(),
                ])
                ->action(function ($data, $record, InvoicePaymentRepository $invoicePaymentRepository): void {
                    try {
                        $invoicePaymentRepository->store($data, $record->id);

                        Notification::make()
                            ->title('Success')
                            ->body('Invoice payment successfully created!')
                            ->color('success')
                            ->send();
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body($e->getMessage())
                            ->color('danger')
                            ->send();
                    }
                }),
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
                            ->body('Invoice successfully marked as ready.')
                            ->color('success')
                            ->send();
                        $this->redirect($this->getRedirectUrl());
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Invoice error')
                            ->body('An error occured while marking invoice as ready.')
                            ->color('danger')
                            ->send();
                    }
                }),
            Actions\Action::make('sendInvoice')
                ->label('Send invoice')
                ->hidden(function ($record) {
                    if ($record->status !== Status::Pending->value) {
                        return true;
                    } elseif ($record->status === Status::Sent->value) {
                        return true;
                    } else {
                        return false;
                    }
                })
                ->action(function ($record): void {
                    try {
                        Mail::to($record->customer->email)
                            ->send(new SendInvoiceEmail($record));
                        Notification::make()
                            ->title('Success')
                            ->body('Successfully sent invoice to customer.')
                            ->color('success')
                            ->send();
                        $record->update(['status' => Status::Sent->value]);
                    } catch (Throwable $e) {
                        Notification::make()
                            ->title('Error')
                            ->body('An error occured while sending invoice to customer.')
                            ->color('danger')
                            ->send();
                    }
                }),
            Actions\Action::make('viewPdf')
                ->label('View PDF')
                ->url(function ($record) {
                    return route('pdf.invoice', $record);
                })
                ->openUrlInNewTab(),
            Actions\Action::make('viewSalesOrder')
                ->label('View Sales Order')
                ->url(function ($record) {
                    $model = str_replace('App\\Models\\', '', get_class($record->sales_order())).'s';
                    $slug = str_replace('_', '-', Str::snake($model));

                    return url("/admin/{$slug}/{$record->sales_order()->id}/edit");
                })
                ->hidden(function ($record) {
                    if ($record->sales_order()) {
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
        return 'Invoice updated';
    }
}
