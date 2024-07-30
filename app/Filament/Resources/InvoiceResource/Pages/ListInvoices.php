<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportInvoiceToExcel')
                ->label('Export Invoices to Excel')
                ->color('success')
                ->url(function () {
                    return url('/user/export-invoices');
                }),
            Actions\CreateAction::make(),
        ];
    }
}
