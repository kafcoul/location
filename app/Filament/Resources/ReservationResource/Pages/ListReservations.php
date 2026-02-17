<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Exports\ReservationCsvExport;
use App\Filament\Exports\ReservationPdfExport;
use App\Filament\Resources\ReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReservations extends ListRecords
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ActionGroup::make([
                Actions\Action::make('export_csv')
                    ->label('Export CSV (toutes)')
                    ->icon('heroicon-o-table-cells')
                    ->color('gray')
                    ->action(fn () => ReservationCsvExport::export()),
                Actions\Action::make('export_csv_confirmed')
                    ->label('Export CSV (confirmées)')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn () => ReservationCsvExport::export('confirmed')),
                Actions\Action::make('export_pdf')
                    ->label('Export PDF (toutes)')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(fn () => ReservationPdfExport::exportAll()),
                Actions\Action::make('export_pdf_confirmed')
                    ->label('Export PDF (confirmées)')
                    ->icon('heroicon-o-document-check')
                    ->color('warning')
                    ->action(fn () => ReservationPdfExport::exportAll('confirmed')),
            ])
                ->label('Exporter')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->button(),
            Actions\CreateAction::make(),
        ];
    }
}
