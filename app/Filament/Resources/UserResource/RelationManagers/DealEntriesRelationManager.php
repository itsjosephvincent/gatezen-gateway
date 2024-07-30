<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enum\Status;
use App\Models\Deal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DealEntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'deal_entries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('deal_id')
                    ->label('Deal')
                    ->options(Deal::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Accepted' => Status::Accepted->value,
                        'Draft' => Status::Draft->value,
                        'Rejected' => Status::Rejected->value,
                        'Sent' => Status::Sent->value,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('dealable_quantity')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('billable_price')
                    ->numeric(),
                Forms\Components\TextInput::make('billable_quantity')
                    ->numeric(),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user_id')
            ->columns([
                Tables\Columns\TextColumn::make('deal.name'),
                Tables\Columns\TextColumn::make('invoice.invoice_number'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('dealable_quantity'),
                Tables\Columns\TextColumn::make('billable_price'),
                Tables\Columns\TextColumn::make('billable_quantity'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewEntity')
                        ->label('View Entity')
                        ->icon('heroicon-o-eye')
                        ->action(function ($record): void {
                            redirect('/admin/deals/'.$record->deal->id.'/edit');
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
