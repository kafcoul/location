<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationLabel = 'Véhicules';
    protected static ?string $modelLabel = 'Véhicule';
    protected static ?string $pluralModelLabel = 'Véhicules';
    protected static ?string $navigationGroup = 'Contenu';
    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view_vehicles') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('create_vehicles') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('city_id')
                            ->relationship('city', 'name')
                            ->required()
                            ->label('Ville'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nom')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('brand')
                            ->label('Marque'),
                        Forms\Components\TextInput::make('model')
                            ->label('Modèle'),
                        Forms\Components\TextInput::make('year')
                            ->label('Année'),
                    ]),

                Forms\Components\Section::make('Tarification')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('price_per_day')
                            ->required()
                            ->numeric()
                            ->suffix('FCFA')
                            ->label('Prix / jour'),
                        Forms\Components\TextInput::make('deposit_amount')
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0)
                            ->label('Caution'),
                        Forms\Components\TextInput::make('km_price')
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0)
                            ->label('Prix / km'),
                        Forms\Components\TextInput::make('weekly_price')
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0)
                            ->label('Prix / semaine'),
                        Forms\Components\TextInput::make('monthly_classic_price')
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0)
                            ->label('Prix mensuel classique'),
                        Forms\Components\TextInput::make('monthly_premium_price')
                            ->numeric()
                            ->suffix('FCFA')
                            ->default(0)
                            ->label('Prix mensuel premium'),
                    ]),

                Forms\Components\Section::make('Caractéristiques')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gearbox')
                            ->options(['Automatique' => 'Automatique', 'Manuelle' => 'Manuelle'])
                            ->required()
                            ->label('Boîte de vitesses'),
                        Forms\Components\Select::make('fuel')
                            ->options(['Essence' => 'Essence', 'Diesel' => 'Diesel', 'Hybride' => 'Hybride', 'Électrique' => 'Électrique'])
                            ->required()
                            ->label('Carburant'),
                        Forms\Components\TextInput::make('power')
                            ->label('Puissance'),
                        Forms\Components\TextInput::make('seats')
                            ->numeric()
                            ->default(5)
                            ->label('Places'),
                        Forms\Components\Toggle::make('carplay')
                            ->label('CarPlay'),
                        Forms\Components\Toggle::make('is_available')
                            ->default(true)
                            ->label('Disponible'),
                    ]),

                Forms\Components\Section::make('Médias & Description')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('vehicles')
                            ->label('Image principale'),
                        Forms\Components\FileUpload::make('gallery')
                            ->image()
                            ->multiple()
                            ->directory('vehicles/gallery')
                            ->label('Galerie'),
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('city:id,name'))
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->label(''),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nom'),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable()
                    ->label('Marque'),
                Tables\Columns\TextColumn::make('city.name')
                    ->sortable()
                    ->label('Ville'),
                Tables\Columns\TextColumn::make('price_per_day')
                    ->numeric()
                    ->suffix(' FCFA')
                    ->sortable()
                    ->label('Prix/jour'),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean()
                    ->label('Dispo'),
                Tables\Columns\TextColumn::make('gearbox')
                    ->label('Boîte'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->label('Créé le')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\SelectFilter::make('city_id')
                    ->relationship('city', 'name')
                    ->label('Ville'),
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Disponibilité'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
