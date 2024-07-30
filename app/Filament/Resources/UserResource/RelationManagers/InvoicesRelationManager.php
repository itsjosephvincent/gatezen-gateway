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

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->options(Project::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->options(Currency::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->options(Language::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('template_id')
                    ->options(PdfTemplate::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Accepted' => Status::Accepted->value,
                        'Cancelled' => Status::Cancelled->value,
                        'Draft' => Status::Draft->value,
                        'Paid' => Status::Paid->value,
                        'Pending' => Status::Pending->value,
                        'Sent' => Status::Sent->value,
                    ])
                    ->required(),
                Forms\Components\TextInput::make('invoice_number')
                    ->required(),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required(),
                Forms\Components\DatePicker::make('due_date'),
                Forms\Components\DatePicker::make('sent_at'),
                Forms\Components\Textarea::make('note'),
                Forms\Components\TextInput::make('reference'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('customer_id')
            ->columns([
                Tables\Columns\TextColumn::make('project.name'),
                Tables\Columns\TextColumn::make('currency.name'),
                Tables\Columns\TextColumn::make('language.name'),
                Tables\Columns\TextColumn::make('template.name'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('invoice_number'),
                Tables\Columns\TextColumn::make('invoice_date'),
                Tables\Columns\TextColumn::make('due_date'),
                Tables\Columns\TextColumn::make('sent_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('viewInvoice')
                        ->label('View Invoice')
                        ->icon('heroicon-o-eye')
                        ->action(function ($record): void {
                            redirect("/admin/invoices/$record->id/edit");
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
