<?php

namespace App\Filament\Resources\VehicleResource\Pages;

use App\Filament\Exports\VehicleCsvExport;
use App\Filament\Resources\VehicleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVehicles extends ListRecords
{
    protected static string $resource = VehicleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export')
                ->label('Exporter CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(fn () => VehicleCsvExport::export()),
            Actions\CreateAction::make(),
        ];
    }
}
