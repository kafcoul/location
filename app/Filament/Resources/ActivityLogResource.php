<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Spatie\Activitylog\Models\Activity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Audit Trail';
    protected static ?string $modelLabel = 'Activité';
    protected static ?string $pluralModelLabel = 'Audit Trail';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?int $navigationSort = 12;

    public static function getNavigationBadge(): ?string
    {
        $count = Activity::where('created_at', '>=', now()->subDay())->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_roles') ?? false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('causer:id,name'))
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->label('Date'),
                Tables\Columns\TextColumn::make('log_name')
                    ->badge()
                    ->color('gray')
                    ->label('Type')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Action')
                    ->wrap(),
                Tables\Columns\TextColumn::make('subject_type')
                    ->formatStateUsing(function (?string $state) {
                        if (!$state) return '—';
                        return match (class_basename($state)) {
                            'User' => 'Utilisateur',
                            'Vehicle' => 'Véhicule',
                            'Reservation' => 'Réservation',
                            'City' => 'Ville',
                            'Role' => 'Rôle',
                            default => class_basename($state),
                        };
                    })
                    ->badge()
                    ->color(fn (?string $state) => match (class_basename($state ?? '')) {
                        'User' => 'info',
                        'Vehicle' => 'warning',
                        'Reservation' => 'success',
                        'City' => 'primary',
                        'Role' => 'danger',
                        default => 'gray',
                    })
                    ->label('Modèle'),
                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Par')
                    ->default('Système')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event')
                    ->badge()
                    ->color(fn (?string $state) => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'created' => 'Création',
                        'updated' => 'Modification',
                        'deleted' => 'Suppression',
                        default => $state ?? '—',
                    })
                    ->label('Événement'),
                Tables\Columns\TextColumn::make('properties')
                    ->label('Changements')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '—';
                        $props = is_string($state) ? json_decode($state, true) : $state->toArray();
                        $changes = [];
                        foreach (($props['attributes'] ?? []) as $key => $value) {
                            $old = $props['old'][$key] ?? '∅';
                            $changes[] = "{$key}: {$old} → {$value}";
                        }
                        return $changes ? implode(', ', array_slice($changes, 0, 3)) . (count($changes) > 3 ? '…' : '') : '—';
                    })
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->size(Tables\Columns\TextColumn\TextColumnSize::ExtraSmall),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([10, 25, 50, 100])
            ->filters([
                Tables\Filters\SelectFilter::make('event')
                    ->options([
                        'created' => 'Création',
                        'updated' => 'Modification',
                        'deleted' => 'Suppression',
                    ])
                    ->label('Événement'),
                Tables\Filters\SelectFilter::make('subject_type')
                    ->options([
                        'App\\Models\\User' => 'Utilisateur',
                        'App\\Models\\Vehicle' => 'Véhicule',
                        'App\\Models\\Reservation' => 'Réservation',
                        'App\\Models\\City' => 'Ville',
                    ])
                    ->label('Modèle'),
                Tables\Filters\SelectFilter::make('causer_id')
                    ->options(fn () => \App\Models\User::pluck('name', 'id')->toArray())
                    ->label('Utilisateur')
                    ->searchable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Du'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Au'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'], fn ($q, $date) => $q->whereDate('created_at', '<=', $date));
                    })
                    ->label('Période'),
                Tables\Filters\Filter::make('today')
                    ->label('Aujourd\'hui')
                    ->query(fn (Builder $query): Builder => $query->whereDate('created_at', today()))
                    ->toggle(),
                Tables\Filters\Filter::make('this_week')
                    ->label('Cette semaine')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->startOfWeek()))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalContent(function (Activity $record) {
                        $properties = $record->properties->toArray();
                        return view('filament.resources.activity-log-details', compact('record', 'properties'));
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->isSuperAdmin()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
