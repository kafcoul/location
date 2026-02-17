<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorAuth extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Authentification 2FA';
    protected static ?string $title = 'Authentification à deux facteurs';
    protected static ?string $navigationGroup = 'Gestion';
    protected static ?int $navigationSort = 20;
    protected static string $view = 'filament.pages.two-factor-auth';

    public ?string $qrCodeSvg = null;
    public ?string $secretKey = null;
    public ?string $verificationCode = '';
    public bool $is2FAEnabled = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->is2FAEnabled = (bool) $user->two_factor_enabled;
    }

    public function generateSecret(): void
    {
        $google2fa = new Google2FA();
        $this->secretKey = $google2fa->generateSecretKey();

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'CKF Motors',
            auth()->user()->email,
            $this->secretKey
        );

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $this->qrCodeSvg = $writer->writeString($qrCodeUrl);

        activity()
            ->causedBy(auth()->user())
            ->log('Génération d\'un nouveau secret 2FA');
    }

    public function enable2FA(): void
    {
        if (!$this->secretKey || !$this->verificationCode) {
            Notification::make()
                ->danger()
                ->title('Veuillez scanner le QR code et entrer le code de vérification')
                ->send();
            return;
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($this->secretKey, $this->verificationCode);

        if (!$valid) {
            Notification::make()
                ->danger()
                ->title('Code de vérification invalide')
                ->body('Le code entré ne correspond pas. Veuillez réessayer.')
                ->send();
            return;
        }

        $user = auth()->user();
        $user->two_factor_secret = Crypt::encryptString($this->secretKey);
        $user->two_factor_enabled = true;
        $user->save();

        $this->is2FAEnabled = true;
        $this->qrCodeSvg = null;
        $this->secretKey = null;
        $this->verificationCode = '';

        activity()
            ->causedBy($user)
            ->log('2FA activé');

        Notification::make()
            ->success()
            ->title('Authentification 2FA activée')
            ->body('Votre compte est maintenant protégé par l\'authentification à deux facteurs.')
            ->send();
    }

    public function disable2FA(): void
    {
        $user = auth()->user();
        $user->two_factor_secret = null;
        $user->two_factor_enabled = false;
        $user->save();

        $this->is2FAEnabled = false;
        $this->qrCodeSvg = null;
        $this->secretKey = null;

        activity()
            ->causedBy($user)
            ->log('2FA désactivé');

        Notification::make()
            ->warning()
            ->title('Authentification 2FA désactivée')
            ->body('L\'authentification à deux facteurs a été désactivée.')
            ->send();
    }
}
