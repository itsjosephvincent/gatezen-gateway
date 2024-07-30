<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\RelationManagers\WalletsRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\AddressRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\AuditsRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\CustomerOrdersRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\DealEntriesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\EntityRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\ExternalRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\UserResource\RelationManagers\KycApplicationRelationManager;
use App\Mail\SendUserPortfolioEmail;
use App\Models\Ticker;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ExchangeService;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Userdata';

    protected static ?int $navigationSort = 20;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('firstname')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middlename')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lastname')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->maxLength(20),
                Forms\Components\DateTimePicker::make('mobile_verified_at')
                    ->visibleOn('edit'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('secondary_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('third_email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, $state): void {
                        $component->state('');
                    })
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('password_changed_at'),
                Forms\Components\Toggle::make('is_blocked')
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->relationship('language', 'name'),
                Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload(),
                Select::make('permissions')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('firstname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('middlename')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('lastname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('secondary_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('third_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\SpatieTagsColumn::make('tags')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('password_changed_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_blocked')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->headerActions([
                Tables\Actions\Action::make('exportUsersToExcel')
                    ->label('Export Users to Excel')
                    ->color('success')
                    ->url(function () {
                        return url('/user/export-users');
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Add assets')
                        ->label('Add assets')
                        ->icon('heroicon-o-plus-circle')
                        ->form([
                            Select::make('ticker')
                                ->label('Ticker')
                                ->options(Ticker::all()->pluck('name', 'id'))
                                ->required()
                                ->multiple(),
                            TextInput::make('shares')
                                ->label('Amount in shares')
                                ->numeric()
                                ->required(),
                            DateTimePicker::make('timestamp')
                                ->label('Transaction timestamp')
                                ->default(now())
                                ->displayFormat('d/m/Y H:i:s')
                                ->native(false)
                                ->required(),
                        ])
                        ->action(function (User $user, array $data, ExchangeService $exchangeService) {
                            $validator = $exchangeService->validateData($data);

                            if ($validator->fails()) {
                                return Notification::make()
                                    ->title('Error')
                                    ->body('The amount shares you entered is invalid!')
                                    ->color('danger')
                                    ->send();
                            }

                            $exchange = $exchangeService->buy($user, $data);

                            if ($exchange === false) {
                                return Notification::make()
                                    ->title('Error')
                                    ->body('An error occured while adding assets.')
                                    ->color('danger')
                                    ->send();
                            }

                            return Notification::make()
                                ->title('Success')
                                ->body('Assets successfully added.')
                                ->color('success')
                                ->send();
                        }),
                    Tables\Actions\Action::make('viewPortfolio')
                        ->label('View Portfolio')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (User $user) {
                            if ($user->wallets()->exists()) {
                                return redirect()->route('pdf.portfolio', $user);
                            } else {
                                Notification::make()
                                    ->title('User portfolio')
                                    ->body('No wallet found for this user!')
                                    ->color('warning')
                                    ->send();
                            }
                        }),
                    Tables\Actions\Action::make('emailPortfolio')
                        ->label('Send Portfolio')
                        ->icon('heroicon-o-paper-airplane')
                        ->url(function (User $user) {
                            return route('pdf.send-portfolio', $user);
                        })
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('blockUser')
                        ->label('Block User')
                        ->icon('heroicon-o-user-minus')
                        ->action(function (User $user, UserRepository $userRepository): void {
                            $userRepository->blockUser($user->id);

                            Notification::make()
                                ->title('Success')
                                ->body('User successfully blocked.')
                                ->color('success')
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->hidden(function (User $user) {
                            if ($user->is_blocked) {
                                return true;
                            }

                            return false;
                        }),
                    Tables\Actions\Action::make('unblockUser')
                        ->label('Unblock User')
                        ->icon('heroicon-o-user-plus')
                        ->action(function (User $user, UserRepository $userRepository): void {
                            $userRepository->unblockUser($user->id);

                            Notification::make()
                                ->title('Success')
                                ->body('User successfully unblocked.')
                                ->color('success')
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->hidden(function (User $user) {
                            if ($user->is_blocked) {
                                return false;
                            }

                            return true;
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('sendPortfolio')
                        ->label('Send Portfolio')
                        ->icon('heroicon-o-paper-airplane')
                        ->action(function (Collection $users): void {
                            $users->each(function ($user): void {
                                if ($user->wallets()->exists()) {
                                    Mail::to($user->email)
                                        ->send(new SendUserPortfolioEmail($user));
                                    Notification::make()
                                        ->title('Email sent!')
                                        ->body('Portfolio successfully sent to '.$user->firstname.'user')
                                        ->color('success')
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('User Portfolio')
                                        ->body('No wallet found for '.$user->firstname.' user')
                                        ->color('warning')
                                        ->send();
                                }
                            });
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('User')
                ->description('User Profile Details')
                ->schema([
                    Infolists\Components\TextEntry::make('name'),
                    Infolists\Components\TextEntry::make('mobile'),
                    Infolists\Components\TextEntry::make('mobile_verified_at'),
                    Infolists\Components\TextEntry::make('email'),
                    Infolists\Components\TextEntry::make('secondary_email'),
                    Infolists\Components\TextEntry::make('third_email'),
                    Infolists\Components\TextEntry::make('email_verified_at'),
                    Infolists\Components\TextEntry::make('is_blocked'),
                    Infolists\Components\TextEntry::make('language.name'),
                ])->columns(2),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            WalletsRelationManager::class,
            EntityRelationManager::class,
            AddressRelationManager::class,
            DealEntriesRelationManager::class,
            CustomerOrdersRelationManager::class,
            InvoicesRelationManager::class,
            KycApplicationRelationManager::class,
            ExternalRelationManager::class,
            AuditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
