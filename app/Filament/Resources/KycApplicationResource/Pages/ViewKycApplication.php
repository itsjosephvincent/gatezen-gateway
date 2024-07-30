<?php

namespace App\Filament\Resources\KycApplicationResource\Pages;

use App\Enum\KycApplicationStatus;
use App\Filament\Resources\KycApplicationResource;
use App\Mail\SendCustomKycEmail;
use App\Services\KycApplicationService;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Mail;

class ViewKycApplication extends ViewRecord
{
    protected static string $resource = KycApplicationResource::class;

    public function getHeading(): string
    {
        $record = $this->getRecord();

        return $record->user->name."'s KYC Application";
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('user.name')
                    ->label('Customer name'),
                TextEntry::make('application_status')
                    ->label('Status'),
                TextEntry::make('reference')
                    ->label('Reference'),
                TextEntry::make('internal_note')
                    ->label('Internal note'),
                TextEntry::make('completed_at'),
                TextEntry::make('created_at')
                    ->label('Date uploaded'),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('process')
                ->label('Process Application')
                ->form([
                    Toggle::make('change_application_status')
                        ->live()
                        ->columnStart(1),
                    Toggle::make('make_internal_note')
                        ->label('Make Internal Note / Reference')
                        ->live()
                        ->columnStart(1),
                    Toggle::make('send_email')
                        ->live()
                        ->columnStart(1),
                    Select::make('application_status')
                        ->options([
                            KycApplicationStatus::Pending->value => 'Pending',
                            KycApplicationStatus::Uploaded->value => 'Uploaded',
                            KycApplicationStatus::Approved->value => 'Approved',
                            KycApplicationStatus::Rejected->value => 'Rejected',
                        ])
                        ->hidden(function (Get $get) {
                            if ($get('change_application_status')) {
                                return false;
                            }

                            return true;
                        }),
                    Textarea::make('internal_note')
                        ->hidden(function (Get $get) {
                            if ($get('make_internal_note')) {
                                return false;
                            }

                            return true;
                        }),
                    TextInput::make('reference')
                        ->hidden(function (Get $get) {
                            if ($get('make_internal_note')) {
                                return false;
                            }

                            return true;
                        }),
                    TextInput::make('subject')
                        ->label('Subject')
                        ->hidden(function (Get $get) {
                            if ($get('send_email')) {
                                return false;
                            }

                            return true;
                        }),
                    Textarea::make('body')
                        ->label('Body')
                        ->rows(6)
                        ->hidden(function (Get $get) {
                            if ($get('send_email')) {
                                return false;
                            }

                            return true;
                        }),
                ])
                ->action(function ($record, $data, KycApplicationService $kycApplicationService): void {
                    if ($data['change_application_status']) {
                        $kycApplicationService->processKycStatus($data, $record);
                    }
                    if ($data['make_internal_note']) {
                        $kycApplicationService->processKycInternalNoteReference($data, $record->user_id);
                    }
                    if ($data['send_email']) {
                        Mail::to($record->user->email)
                            ->send(new SendCustomKycEmail($data));
                        Notification::make()
                            ->title('Email sent.')
                            ->body('Your email has been successfully sent!')
                            ->color('success')
                            ->send();
                        activity()
                            ->causedBy(auth()->user())
                            ->performedOn($record)
                            ->event('sent email')
                            ->log("Sent email to {$record->user->name}\nSubject: {$data['subject']}\nMessage: {$data['body']}");
                    }
                })
                ->hidden(function ($record) {
                    if ($record->application_status === KycApplicationStatus::Approved->value) {
                        return true;
                    }

                    return false;
                }),
        ];
    }
}
