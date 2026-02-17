<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestReservations extends BaseWidget
{
    protected static ?string $heading = 'Dernières réservations';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservation::query()
                    ->with('vehicle:id,name')
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Client')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.name')
                    ->label('Véhicule'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Tél'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->label('Début'),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->label('Fin'),
                Tables\Columns\TextColumn::make('estimated_total')
                    ->numeric()
                    ->suffix(' FCFA')
                    ->label('Total'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        default => $state,
                    })
                    ->label('Statut'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Date'),
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->label('Confirmer')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Reservation $record) => $record->status === 'pending' && auth()->user()?->can('confirm_reservations'))
                    ->action(fn (Reservation $record) => $record->update(['status' => 'confirmed'])),
            ])
            ->paginated(false);
    }
}
