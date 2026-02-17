<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorVerify extends Page
{
    protected static ?string $navigationIcon = null;
    protected static ?string $title = 'Vérification 2FA';
    protected static string $view = 'filament.pages.two-factor-verify';
    protected static bool $shouldRegisterNavigation = false;
    protected static string $routePath = '/2fa-verify';

    public ?string $code = '';

    public function verify(): void
    {
        $user = auth()->user();

        if (!$user->two_factor_enabled || !$user->two_factor_secret) {
            session()->put('2fa_verified', true);
            $this->redirect('/admin');
            return;
        }

        $google2fa = new Google2FA();
        $secret = Crypt::decryptString($user->two_factor_secret);

        if ($google2fa->verifyKey($secret, $this->code)) {
            session()->put('2fa_verified', true);

            activity()
                ->causedBy($user)
                ->log('Vérification 2FA réussie');

            $this->redirect('/admin');
        } else {
            Notification::make()
                ->danger()
                ->title('Code invalide')
                ->body('Le code de vérification est incorrect.')
                ->send();

            activity()
                ->causedBy($user)
                ->withProperties(['ip' => request()->ip()])
                ->log('Échec vérification 2FA');

            $this->code = '';
        }
    }

    public function logout(): void
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/admin/login');
    }
}
