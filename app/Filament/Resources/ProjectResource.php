<?php

namespace App\Filament\Resources;

use App\Enum\QueryType;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Interface\Repositories\ProjectSyncRepositoryInterface;
use App\Jobs\SyncShareJob;
use App\Jobs\SyncTgiBankTransactionJob;
use App\Jobs\SyncUserJob;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Throwable;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $slug = 'projects';

    protected static ?string $navigationLabel = 'Projects';

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationGroup = 'Projects';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('uuid')
                    ->readOnly()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('public_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('public_url')
                    ->maxLength(255),
                Forms\Components\SpatieTagsInput::make('tags'),
                Forms\Components\FileUpload::make('featured_image')
                    ->disk('featured')
                    ->image(),
                Forms\Components\FileUpload::make('logo_url')
                    ->label('Logo')
                    ->disk('logo')
                    ->image(),
                Forms\Components\TextInput::make('summary')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_activate')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('public_name')
                    ->searchable(),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('public_url')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('syncProjectUsers')
                        ->label('Sync Users to Gateway')
                        ->icon('heroicon-m-users')
                        ->registerModalActions([
                            Action::make('sync')
                                ->label('Sync')
                                ->color('success')
                                ->action(function ($record): void {
                                    SyncUserJob::dispatch($record, QueryType::Users->value);

                                    Notification::make()
                                        ->title('Success')
                                        ->body('Sync is now in progress, you can close the pop-up window.')
                                        ->color('success')
                                        ->send();
                                }),
                        ])
                        ->modalContent(function (Action $action, $record, ProjectSyncRepositoryInterface $projectSyncRepository) {
                            try {
                                $users = $projectSyncRepository->findMany($record, QueryType::Users->value);

                                return view('filament.project.sync', [
                                    'users' => $users,
                                    'type' => QueryType::Users->value,
                                    'action' => $action,
                                ]);
                            } catch (Throwable $e) {
                                Notification::make()
                                    ->title('Error')
                                    ->body($e->getMessage())
                                    ->color('danger')
                                    ->send();
                            }
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false),
                    Tables\Actions\Action::make('syncProjectShares')
                        ->label('Sync Shares to Gateway')
                        ->icon('heroicon-m-banknotes')
                        ->registerModalActions([
                            Action::make('sync')
                                ->label('Sync')
                                ->color('success')
                                ->action(function ($record): void {
                                    SyncShareJob::dispatch($record, QueryType::Shares->value);

                                    Notification::make()
                                        ->title('Success')
                                        ->body('Sync is now in progress, you can close the pop-up window.')
                                        ->color('success')
                                        ->send();
                                }),
                        ])
                        ->modalContent(function (Action $action, $record, ProjectSyncRepositoryInterface $projectSyncRepository) {
                            try {
                                $users = $projectSyncRepository->findMany($record, QueryType::Shares->value);

                                return view('filament.project.sync', [
                                    'users' => $users,
                                    'type' => QueryType::Shares->value,
                                    'action' => $action,
                                ]);
                            } catch (Throwable $e) {
                                Notification::make()
                                    ->title('Error')
                                    ->body($e->getMessage())
                                    ->color('danger')
                                    ->send();
                            }
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false),
                    Tables\ACtions\Action::make('syncBankTransactions')
                        ->label('Sync Bank Transactions')
                        ->icon('heroicon-m-building-library')
                        ->hidden(function ($record) {
                            if ($record->name == 'Craftwill Capital ESG') {
                                return false;
                            }

                            return true;
                        })
                        ->registerModalActions([
                            Action::make('sync')
                                ->label('Sync Bank Transactions')
                                ->color('success')
                                ->action(function ($record): void {
                                    SyncTgiBankTransactionJob::dispatch($record, QueryType::Bank->value);

                                    Notification::make()
                                        ->title('Success')
                                        ->body('Sync is now in progress, you can close the pop-up window.')
                                        ->color('success')
                                        ->send();
                                }),
                        ])
                        ->modalContent(function (Action $action, $record, ProjectSyncRepositoryInterface $projectSyncRepository) {
                            try {
                                $users = $projectSyncRepository->findMany($record, QueryType::Bank->value);

                                return view('filament.project.bank-transaction', [
                                    'users' => $users,
                                    'action' => $action,
                                ]);
                            } catch (Throwable $e) {
                                Notification::make()
                                    ->title('Error')
                                    ->body($e->getMessage())
                                    ->color('danger')
                                    ->send();
                            }
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(false),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('name')
                    ->weight(FontWeight::Bold),
                Infolists\Components\TextEntry::make('public_name')
                    ->weight(FontWeight::Bold),
                Infolists\Components\ImageEntry::make('logo_url')
                    ->disk('logo'),
                Infolists\Components\ImageEntry::make('featured_image')
                    ->disk('featured'),
                Infolists\Components\TextEntry::make('description')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('shares')
                    ->label('Number of shares'),
                Infolists\Components\TextEntry::make('uuid'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TickersRelationManager::class,
            RelationManagers\WalletsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'view' => Pages\ViewProject::route('/{record}'),
        ];
    }
}
