<div class="space-y-4 p-2">

    {{-- Métadonnées --}}
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div>
            <span class="font-semibold text-gray-500 dark:text-gray-400">Date :</span>
            <span>{{ $record->created_at->format('d/m/Y H:i:s') }}</span>
        </div>
        <div>
            <span class="font-semibold text-gray-500 dark:text-gray-400">Par :</span>
            <span>{{ $record->causer?->name ?? 'Système' }}</span>
        </div>
        <div>
            <span class="font-semibold text-gray-500 dark:text-gray-400">Événement :</span>
            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium
                {{ match($record->event) {
                    'created' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300',
                    'updated' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300',
                    'deleted' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                    default => 'bg-gray-100 text-gray-700',
                } }}">
                {{ match($record->event) { 'created' => 'Création', 'updated' => 'Modification', 'deleted' => 'Suppression', default => $record->event ?? '—' } }}
            </span>
        </div>
        <div>
            <span class="font-semibold text-gray-500 dark:text-gray-400">Modèle :</span>
            <span>{{ class_basename($record->subject_type ?? '') }} #{{ $record->subject_id }}</span>
        </div>
        @if($record->causer)
        <div>
            <span class="font-semibold text-gray-500 dark:text-gray-400">IP :</span>
            <span class="font-mono text-xs">{{ $properties['ip'] ?? '—' }}</span>
        </div>
        @endif
    </div>

    {{-- Description --}}
    <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm">
        <span class="font-semibold text-gray-500 dark:text-gray-400">Description :</span>
        {{ $record->description }}
    </div>

    {{-- Tableau des modifications --}}
    @if(!empty($properties['old'] ?? []) || !empty($properties['attributes'] ?? []))
        <div class="mt-4">
            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">📝 Détail des modifications</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-400">Champ</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-400">
                                <span class="text-red-500">●</span> Avant
                            </th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-400">
                                <span class="text-emerald-500">●</span> Après
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($properties['attributes'] ?? [] as $key => $value)
                            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="px-4 py-2 font-mono text-xs font-semibold">{{ $key }}</td>
                                <td class="px-4 py-2">
                                    @if(isset($properties['old'][$key]))
                                        <span class="inline-block bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-2 py-0.5 rounded font-mono text-xs">
                                            {{ is_array($properties['old'][$key]) ? json_encode($properties['old'][$key]) : $properties['old'][$key] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">∅</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <span class="inline-block bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-2 py-0.5 rounded font-mono text-xs">
                                        {{ is_array($value) ? json_encode($value) : $value }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($record->event === 'created' && !empty($properties['attributes'] ?? []))
        <div class="mt-4">
            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">🆕 Valeurs initiales</h4>
            <div class="grid grid-cols-2 gap-2 text-sm">
                @foreach($properties['attributes'] as $key => $value)
                    <div class="flex gap-2">
                        <span class="font-mono text-xs text-gray-500">{{ $key }}:</span>
                        <span class="text-emerald-600 dark:text-emerald-400 text-xs font-mono">{{ is_array($value) ? json_encode($value) : $value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-sm text-gray-500 italic mt-4">Aucun détail de modification disponible.</div>
    @endif
</div>
