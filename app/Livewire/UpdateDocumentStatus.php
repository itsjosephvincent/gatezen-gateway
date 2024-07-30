<?php

namespace App\Livewire;

use App\Enum\KycDocumentStatus;
use App\Services\KycDocumentService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class UpdateDocumentStatus extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public $doc;

    public function mount(Model $record): void
    {
        $this->doc = $record;
        $this->form->fill();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->label('Update Status')
                    ->options([
                        KycDocumentStatus::Pending->value => 'Pending',
                        KycDocumentStatus::Waiting->value => 'Waiting for feedback',
                        KycDocumentStatus::Rejected->value => 'Reject',
                        KycDocumentStatus::Approved->value => 'Approve',
                    ])
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set): void {
                        if ($get('status') == KycDocumentStatus::Rejected->value) {
                            $set('rejected_at', Carbon::now());
                        }
                        if ($get('status') == KycDocumentStatus::Approved->value) {
                            $set('approved_at', Carbon::now());
                        }
                    })
                    ->required(),
                Textarea::make('internal_note'),
                Textarea::make('external_note')
                    ->hidden(function (Get $get) {
                        if ($get('status') == KycDocumentStatus::Rejected->value) {
                            return false;
                        }

                        return true;
                    })
                    ->required(function (Get $get) {
                        if ($get('status') == KycDocumentStatus::Rejected->value) {
                            return true;
                        }

                        return false;
                    }),
                Hidden::make('rejected_at'),
                Hidden::make('approved_at'),
            ])
            ->statePath('data');
    }

    public function saveAction(): Action
    {
        return Action::make('save')
            ->label('Save')
            ->action(function (KycDocumentService $kycDocumentService): void {
                $statusData = $this->form->getState();
                $kycDocumentService->updateKycDocument($statusData, $this->doc);
            });
    }

    public function render()
    {
        return view('livewire.update-document-status');
    }
}
