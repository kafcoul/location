<x-filament-panels::page>
    <div class="max-w-md mx-auto">
        <div class="rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-8 space-y-6 text-center">
            <x-heroicon-o-shield-check class="w-16 h-16 text-amber-500 mx-auto" />

            <div>
                <h2 class="text-xl font-bold">Vérification 2FA</h2>
                <p class="text-sm text-gray-500 mt-2">Entrez le code à 6 chiffres de votre application d'authentification.</p>
            </div>

            <div class="max-w-xs mx-auto">
                <input
                    type="text"
                    wire:model="code"
                    wire:keydown.enter="verify"
                    placeholder="000000"
                    maxlength="6"
                    autofocus
                    class="fi-input block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-center text-3xl tracking-[0.5em] font-mono shadow-sm focus:border-primary-500 focus:ring-primary-500"
                />
            </div>

            <div class="flex flex-col gap-3">
                <x-filament::button wire:click="verify" class="w-full">
                    Vérifier
                </x-filament::button>

                <x-filament::button wire:click="logout" color="gray" class="w-full">
                    Se déconnecter
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
