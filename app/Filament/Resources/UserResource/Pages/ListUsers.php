<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Imports\UserImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ListUsers extends ListRecords
{
    public $file = '';

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();

        return view('filament.user.custom-import', compact('data'));
    }

    public function save(): void
    {
        if ($this->file != '') {
            Excel::import(new UserImport, $this->file);
        }
    }
}
