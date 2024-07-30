<?php

namespace App\Filament\Resources\KycApplicationResource\RelationManagers;

use App\Enum\KycDocumentStatus;
use App\Enum\Permissions;
use App\Livewire\UpdateDocumentStatus;
use App\Services\KycDocumentService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class KycDocumentsRelationManager extends RelationManager
{
    protected static string $relationship = 'kyc_documents';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->live()
                    ->options([
                        KycDocumentStatus::Pending->value => 'Pending',
                        KycDocumentStatus::Waiting->value => 'Waiting for feedback',
                        KycDocumentStatus::Rejected->value => 'Rejected',
                        KycDocumentStatus::Approved->value => 'Approved',
                    ])
                    ->afterStateUpdated(function (Get $get, Set $set): void {
                        if ($get('status') === KycDocumentStatus::Rejected->value) {
                            $set('rejected_at', Carbon::now());
                        }
                        if ($get('status') === KycDocumentStatus::Approved->value) {
                            $set('approved_at', Carbon::now());
                        }
                    }),
                Forms\Components\Textarea::make('internal_note')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('external_note')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rejected_at')
                    ->live(),
                Forms\Components\TextInput::make('approved_at')
                    ->live(),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('document_type.name')
                    ->label('Document type'),
                TextEntry::make('file')
                    ->limit(20)
                    ->label('File')
                    ->suffixAction(
                        Action::make('download')
                            ->icon('heroicon-o-arrow-down-tray')
                            ->url(function ($record) {
                                return route('kyc.download', $record->id);
                            })
                    ),
                TextEntry::make('status')
                    ->label('Document status'),
                TextEntry::make('internal_note')
                    ->label('Internal note'),
                TextEntry::make('external_note')
                    ->label('External note'),
                TextEntry::make('rejected_at')
                    ->hidden(function ($record) {
                        if ($record->rejected_at) {
                            return false;
                        }

                        return true;
                    }),
                TextEntry::make('approved_at')
                    ->hidden(function ($record) {
                        if ($record->approved_at) {
                            return false;
                        }

                        return true;
                    }),
                TextEntry::make('completed_at'),
                TextEntry::make('created_at')
                    ->label('Date uploaded'),
                Livewire::make(UpdateDocumentStatus::class)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_type.name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('Date uploaded')
                    ->default(function ($record) {
                        return Carbon::parse($record->created_at)->format('Y-m-d H:i:s');
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->disabled(function ($record) {
                            if ($record->status == KycDocumentStatus::Rejected->value) {
                                return true;
                            }

                            return false;
                        }),
                    Tables\Actions\Action::make('viewDocument')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(function ($record) {
                            return route('kyc.download', $record->id);
                        })
                        ->hidden(function () {
                            $user = auth()->user();
                            $userPermission = json_decode($user->getPermissionNames(), true);
                            if (in_array(Permissions::ViewPermissions->value, $userPermission)) {
                                return false;
                            }

                            return true;
                        }),
                    Tables\Actions\Action::make('deleteDocument')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->action(function ($record, KycDocumentService $kycDocumentService): void {
                            $kycDocumentService->deleteDocument($record->id);
                        })
                        ->requiresConfirmation(),
                ])
                    ->hidden(function () {
                        $record = $this->getOwnerRecord();
                        if ($record->application_status === KycDocumentStatus::Rejected->value) {
                            return true;
                        }

                        return false;
                    }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
