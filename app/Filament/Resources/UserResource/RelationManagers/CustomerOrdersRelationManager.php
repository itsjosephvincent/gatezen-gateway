<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enum\Status;
use App\Models\Currency;
use App\Models\Language;
use App\Models\PdfTemplate;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerOrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'customer_orders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->options(Project::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->options(Language::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->options(Currency::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('template_id')
                    ->options(PdfTemplate::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Accepted' => Status::Accepted->value,
                        'Cancelled' => Status::Cancelled->value,
                        'Draft' => Status::Draft->value,
                        'Invoiced' => Status::Invoiced->value,
                        'Pending' => Status::Pending->value,
                        'Sent' => Status::Sent->value,
                    ])
                    ->required(),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('reference'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('customer_id')
            ->columns([
                Tables\Columns\TextColumn::make('project.name'),
                Tables\Columns\TextColumn::make('invoice.number'),
                Tables\Columns\TextColumn::make('language.name'),
                Tables\Columns\TextColumn::make('currency.name'),
                Tables\Columns\TextColumn::make('template.name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('order_number'),
                Tables\Columns\TextColumn::make('order_date'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewSalesOrder')
                        ->label('View Order')
                        ->icon('heroicon-o-eye')
                        ->action(function ($record): void {
                            redirect("/admin/sales-orders/$record->id/edit");
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
