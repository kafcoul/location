<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;

class MaintenanceMode extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = 'Maintenance';
    protected static ?string $title = 'Mode Maintenance';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?int $navigationSort = 15;

    protected static string $view = 'filament.pages.maintenance-mode';

    public static function canAccess(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }

    public function isInMaintenance(): bool
    {
        return app()->isDownForMaintenance();
    }

    protected function getHeaderActions(): array
    {
        if ($this->isInMaintenance()) {
            return [
                Action::make('disable')
                    ->label('Désactiver la maintenance')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Remettre le site en ligne ?')
                    ->modalDescription('Le site sera à nouveau accessible à tous les visiteurs.')
                    ->action(function () {
                        Artisan::call('up');

                        Notification::make()
                            ->title('Site remis en ligne')
                            ->body('Le mode maintenance a été désactivé.')
                            ->success()
                            ->send();

                        $this->redirect(static::getUrl());
                    }),
            ];
        }

        return [
            Action::make('enable')
                ->label('Activer la maintenance')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Mettre le site en maintenance ?')
                ->modalDescription('Les visiteurs verront la page de maintenance. Le panel admin restera accessible. Un secret sera généré pour bypass.')
                ->action(function () {
                    $secret = bin2hex(random_bytes(16));

                    Artisan::call('down', [
                        '--secret' => $secret,
                        '--render' => 'errors.503',
                    ]);

                    Notification::make()
                        ->title('Mode maintenance activé')
                        ->body("Secret de bypass : {$secret}")
                        ->warning()
                        ->persistent()
                        ->send();

                    $this->redirect(static::getUrl());
                }),
        ];
    }
}
