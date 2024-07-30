<?php

namespace App\Filament\Resources;

use App\Enum\Status;
use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers\InvoicePaymentsRelationManager;
use App\Filament\Resources\InvoiceResource\RelationManagers\InvoiceProductsRelationManager;
use App\Jobs\SyncZohoBooksPayment;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 33;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name'),
                Forms\Components\Select::make('customer_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->default(1)
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->relationship('language', 'name')
                    ->default(1)
                    ->required(),
                Forms\Components\Select::make('template_id')
                    ->label('PDF template')
                    ->relationship('template', 'name'),
                Forms\Components\DatePicker::make('invoice_date')
                    ->default(Carbon::now())
                    ->format('Y-m-d')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->default(Carbon::now()->addDays(5))
                    ->format('Y-m-d')
                    ->required(),
                Forms\Components\TextInput::make('reference'),
                Forms\Components\Textarea::make('note')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.name'),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable(['firstname', 'middlename', 'lastname']),
                Tables\Columns\TextColumn::make('currency.name'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total gross')
                    ->default(function ($record) {
                        return number_format($record->calculateTotalGross(), 4, '.', ',');
                    })
                    ->prefix(function ($record) {
                        return $record->currency->symbol;
                    }),
                Tables\Columns\TextColumn::make('balance')
                    ->label('Balance')
                    ->prefix(function ($record) {
                        return $record->currency->symbol;
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('emailInvoice')
                        ->label('Email Invoice')
                        ->icon('heroicon-o-paper-airplane')
                        ->url(function ($record) {
                            return route('pdf.send-invoice', $record);
                        })
                        ->openUrlInNewTab()
                        ->hidden(function ($record) {
                            if ($record->status != Status::Draft->value) {
                                return false;
                            }

                            return true;
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('syncPayments')
                        ->label('Sync Zoho Invoice Payment')
                        ->icon('heroicon-o-banknotes')
                        ->action(function (Collection $invoices): void {
                            SyncZohoBooksPayment::dispatch($invoices);
                            Notification::make()
                                ->title('Success')
                                ->body('Invoice payment sync is now in progress.')
                                ->color('success')
                                ->send();
                        }),
                ]),
            ])
            ->paginated([10, 25, 50, 100, 'all']);
    }

    public static function getRelations(): array
    {
        return [
            InvoiceProductsRelationManager::class,
            InvoicePaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
