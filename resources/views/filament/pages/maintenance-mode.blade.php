<x-filament-panels::page>

    <div class="space-y-6">

        {{-- Statut actuel --}}
        <div class="rounded-xl border p-6 {{ $this->isInMaintenance() ? 'border-red-200 bg-red-50 dark:border-red-800 dark:bg-red-900/20' : 'border-emerald-200 bg-emerald-50 dark:border-emerald-800 dark:bg-emerald-900/20' }}">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0">
                    @if($this->isInMaintenance())
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50">
                            <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600 dark:text-red-400" />
                        </div>
                    @else
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/50">
                            <x-heroicon-o-check-circle class="h-6 w-6 text-emerald-600 dark:text-emerald-400" />
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-semibold {{ $this->isInMaintenance() ? 'text-red-800 dark:text-red-200' : 'text-emerald-800 dark:text-emerald-200' }}">
                        {{ $this->isInMaintenance() ? '🔴 Site en maintenance' : '🟢 Site en ligne' }}
                    </h3>
                    <p class="text-sm {{ $this->isInMaintenance() ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                        @if($this->isInMaintenance())
                            Les visiteurs voient la page de maintenance CKF Motors. Le panel admin reste accessible.
                        @else
                            Le site est accessible à tous les visiteurs.
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Info --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-4">
            <h3 class="font-semibold text-gray-900 dark:text-white">ℹ️ Comment ça fonctionne</h3>
            <div class="grid gap-3 text-sm text-gray-600 dark:text-gray-400">
                <div class="flex gap-2">
                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">1</span>
                    <span>En mode maintenance, les visiteurs voient une page élégante « maintenance en cours » avec le design CKF Motors.</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">2</span>
                    <span>Le <strong>panel admin</strong> (<code>/admin</code>) reste entièrement accessible — vous pouvez continuer à travailler.</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">3</span>
                    <span>Un <strong>secret de bypass</strong> est généré. Visitez <code>votre-site.com/{secret}</code> pour contourner la maintenance.</span>
                </div>
                <div class="flex gap-2">
                    <span class="font-mono text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">4</span>
                    <span>Commandes manuelles : <code>php artisan down --secret=XXXX --render=errors.503</code> / <code>php artisan up</code></span>
                </div>
            </div>
        </div>

    </div>

</x-filament-panels::page>
