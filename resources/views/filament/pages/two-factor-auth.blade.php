<x-filament-panels::page>
    <div class="space-y-6">

        @if($is2FAEnabled)
            <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-shield-check class="w-12 h-12 text-emerald-500" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-emerald-800 dark:text-emerald-200">2FA Activé</h3>
                        <p class="text-sm text-emerald-600 dark:text-emerald-400">Votre compte est protégé par l'authentification à deux facteurs.</p>
                    </div>
                </div>
                <div class="mt-4">
                    <x-filament::button color="danger" wire:click="disable2FA" wire:confirm="Êtes-vous sûr de vouloir désactiver la 2FA ?">
                        Désactiver la 2FA
                    </x-filament::button>
                </div>
            </div>
        @else
            <div class="rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-6">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <x-heroicon-o-shield-exclamation class="w-12 h-12 text-amber-500" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-200">2FA Désactivé</h3>
                        <p class="text-sm text-amber-600 dark:text-amber-400">Protégez votre compte en activant l'authentification à deux facteurs.</p>
                    </div>
                </div>
            </div>

            @if(!$qrCodeSvg)
                <x-filament::button wire:click="generateSecret">
                    Configurer la 2FA
                </x-filament::button>
            @else
                <div class="rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-6 space-y-6">
                    <h3 class="text-lg font-semibold">Étape 1 : Scannez le QR code</h3>
                    <p class="text-sm text-gray-500">Ouvrez votre application d'authentification (Google Authenticator, Authy, etc.) et scannez ce QR code.</p>

                    <div class="flex justify-center p-4 bg-white rounded-lg">
                        {!! $qrCodeSvg !!}
                    </div>

                    <div class="text-center">
                        <p class="text-xs text-gray-400">Clé secrète (si vous ne pouvez pas scanner) :</p>
                        <code class="text-sm font-mono bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded">{{ $secretKey }}</code>
                    </div>

                    <h3 class="text-lg font-semibold">Étape 2 : Entrez le code de vérification</h3>
                    <div class="max-w-xs">
                        <input
                            type="text"
                            wire:model="verificationCode"
                            placeholder="000000"
                            maxlength="6"
                            class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-center text-2xl tracking-[0.5em] font-mono shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>

                    <x-filament::button wire:click="enable2FA" color="success">
                        Activer la 2FA
                    </x-filament::button>
                </div>
            @endif
        @endif

    </div>
</x-filament-panels::page>
