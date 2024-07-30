<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Imports\WalletImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $createAction = Actions\CreateAction::make()
            ->label('New transaction');

        return view('filament.wallet.custom-import', [
            'createAction' => $createAction,
        ]);
    }

    public $file = '';

    public function save(): void
    {
        if ($this->file != '') {
            Excel::import(new WalletImport, $this->file);
        }
    }
}
