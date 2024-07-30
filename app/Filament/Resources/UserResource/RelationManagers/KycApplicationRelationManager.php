<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enum\KycApplicationStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class KycApplicationRelationManager extends RelationManager
{
    protected static string $relationship = 'kyc_application';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('application_status')
                    ->options([
                        'Uploaded' => KycApplicationStatus::Uploaded->value,
                        'Rejected' => KycApplicationStatus::Rejected->value,
                        'Approved' => KycApplicationStatus::Approved->value,
                        'Pending' => KycApplicationStatus::Pending->value,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('reference'),
                Forms\Components\Textarea::make('internal_note'),
                Forms\Components\DatePicker::make('completed_at'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns([
                Tables\Columns\TextColumn::make('application_status'),
                Tables\Columns\TextColumn::make('completed_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewKyc')
                        ->label('View KYC')
                        ->icon('heroicon-o-eye')
                        ->action(function ($record): void {
                            redirect("/admin/kyc-applications/$record->id");
                        }),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
