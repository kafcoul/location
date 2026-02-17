<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Filament\Exports\ReservationPdfExport;
use App\Models\Reservation;
use App\Notifications\ReservationConfirmedNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Notification;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Réservations';
    protected static ?string $modelLabel = 'Réservation';
    protected static ?string $pluralModelLabel = 'Réservations';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_reservations') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_reservations') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Client')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom'),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom'),
                        Forms\Components\TextInput::make('full_name')
                            ->label('Nom complet'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->label('Téléphone'),
                        Forms\Components\TextInput::make('license_seniority')
                            ->label('Ancienneté permis'),
                    ]),

                Forms\Components\Section::make('Réservation')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('vehicle_id')
                            ->relationship('vehicle', 'name')
                            ->required()
                            ->label('Véhicule'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'En attente',
                                'confirmed' => 'Confirmée',
                                'cancelled' => 'Annulée',
                            ])
                            ->required()
                            ->label('Statut'),
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->label('Début'),
                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->label('Fin'),
                        Forms\Components\TextInput::make('total_days')
                            ->numeric()
                            ->label('Jours'),
                        Forms\Components\TextInput::make('estimated_total')
                            ->numeric()
                            ->suffix('FCFA')
                            ->label('Total estimé'),
                    ]),

                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->label('Précisions'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('vehicle:id,name'))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->label('Client'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Tél')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle.name')
                    ->sortable()
                    ->label('Véhicule'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Début'),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d/m/Y')
                    ->sortable()
                    ->label('Fin'),
                Tables\Columns\TextColumn::make('total_days')
                    ->label('Jours')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('estimated_total')
                    ->numeric()
                    ->suffix(' FCFA')
                    ->sortable()
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
                    ->sortable()
                    ->label('Créée le')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginationPageOptions([10, 25, 50])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                    ])
                    ->label('Statut'),
                Tables\Filters\SelectFilter::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->label('Véhicule'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('gray')
                    ->action(fn (Reservation $record) => ReservationPdfExport::single($record)),
                Tables\Actions\Action::make('confirm')
                    ->label('Confirmer')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Reservation $record) => $record->status === 'pending' && auth()->user()?->can('confirm_reservations'))
                    ->action(function (Reservation $record) {
                        $record->update(['status' => 'confirmed']);
                        $record->load('vehicle');

                        // Email de confirmation au client
                        Notification::route('mail', $record->email)
                            ->notify(new ReservationConfirmedNotification($record));
                    }),
                Tables\Actions\Action::make('cancel')
                    ->label('Annuler')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Reservation $record) => $record->status !== 'cancelled' && auth()->user()?->can('cancel_reservations'))
                    ->action(fn (Reservation $record) => $record->update(['status' => 'cancelled'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
