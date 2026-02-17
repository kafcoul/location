<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Rôles';
    protected static ?string $modelLabel = 'Rôle';
    protected static ?string $pluralModelLabel = 'Rôles';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?int $navigationSort = 11;

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_roles') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_roles') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du rôle')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->label('Nom du rôle')
                            ->disabled(fn (?Role $record) => $record && in_array($record->name, ['Super Admin', 'Admin', 'Manager', 'Support'])),
                        Forms\Components\Select::make('permissions')
                            ->multiple()
                            ->relationship('permissions', 'name')
                            ->preload()
                            ->label('Permissions')
                            ->disabled(fn (?Role $record) => $record?->name === 'Super Admin'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Rôle')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Super Admin' => 'danger',
                        'Admin' => 'warning',
                        'Manager' => 'info',
                        'Support' => 'gray',
                        default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Utilisateurs')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->label('Créé le'),
            ])
            ->defaultSort('name')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (Role $record) => !in_array($record->name, ['Super Admin', 'Admin', 'Manager', 'Support'])),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
