@php
    $action = $vehicle
        ? route('admin.vehicles.update', $vehicle)
        : route('admin.vehicles.store');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-2xl">
    @csrf
    @if($vehicle) @method('PUT') @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <label class="block text-sm font-medium mb-1">Ville *</label>
        <select name="city_id" required class="w-full border rounded px-3 py-2">
            <option value="">— Choisir —</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" @selected(old('city_id', $vehicle?->city_id) == $city->id)>{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Marque *</label>
            <input type="text" name="brand" value="{{ old('brand', $vehicle?->brand) }}" required class="w-full border rounded px-3 py-2" placeholder="BMW, AUDI, MERCEDES-BENZ...">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Modèle *</label>
            <input type="text" name="model" value="{{ old('model', $vehicle?->model) }}" required class="w-full border rounded px-3 py-2" placeholder="X6 M50D, Q3 SPORTBACK...">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Nom complet *</label>
        <input type="text" name="name" value="{{ old('name', $vehicle?->name) }}" required class="w-full border rounded px-3 py-2" placeholder="BMW X6 M50D">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Prix / jour *</label>
            <input type="number" name="price_per_day" value="{{ old('price_per_day', $vehicle?->price_per_day) }}" required min="1" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Caution *</label>
            <input type="number" name="deposit_amount" value="{{ old('deposit_amount', $vehicle?->deposit_amount) }}" required min="0" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Prix / km</label>
            <input type="number" step="0.01" name="km_price" value="{{ old('km_price', $vehicle?->km_price) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Prix hebdo</label>
            <input type="number" name="weekly_price" value="{{ old('weekly_price', $vehicle?->weekly_price) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Prix mensuel Classic</label>
            <input type="number" name="monthly_classic_price" value="{{ old('monthly_classic_price', $vehicle?->monthly_classic_price) }}" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Prix mensuel Premium</label>
            <input type="number" name="monthly_premium_price" value="{{ old('monthly_premium_price', $vehicle?->monthly_premium_price) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Année</label>
            <input type="text" name="year" maxlength="4" value="{{ old('year', $vehicle?->year) }}" class="w-full border rounded px-3 py-2" placeholder="2023">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Boîte</label>
            <select name="gearbox" class="w-full border rounded px-3 py-2">
                <option value="Automatique" @selected(old('gearbox', $vehicle?->gearbox) === 'Automatique')>Automatique</option>
                <option value="Manuelle" @selected(old('gearbox', $vehicle?->gearbox) === 'Manuelle')>Manuelle</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Puissance</label>
            <input type="text" name="power" value="{{ old('power', $vehicle?->power) }}" class="w-full border rounded px-3 py-2" placeholder="400 ch">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Places</label>
            <input type="number" name="seats" value="{{ old('seats', $vehicle?->seats ?? 5) }}" min="1" max="9" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Carburant</label>
            <select name="fuel" class="w-full border rounded px-3 py-2">
                <option value="Essence" @selected(old('fuel', $vehicle?->fuel) === 'Essence')>Essence</option>
                <option value="Diesel" @selected(old('fuel', $vehicle?->fuel) === 'Diesel')>Diesel</option>
                <option value="Hybride" @selected(old('fuel', $vehicle?->fuel) === 'Hybride')>Hybride</option>
                <option value="Électrique" @selected(old('fuel', $vehicle?->fuel) === 'Électrique')>Électrique</option>
            </select>
        </div>
        <div>
            <label class="inline-flex items-center gap-2 mt-6">
                <input type="checkbox" name="carplay" value="1" @checked(old('carplay', $vehicle?->carplay ?? true))>
                <span class="text-sm">CarPlay</span>
            </label>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $vehicle?->description) }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Image principale</label>
        <input type="file" name="image" accept="image/*" class="w-full">
        @if($vehicle?->image)
            <p class="text-xs text-gray-500 mt-1">Image actuelle : {{ $vehicle->image }}</p>
        @endif
    </div>

    <div>
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $vehicle?->is_available ?? true))>
            <span class="text-sm">Disponible</span>
        </label>
    </div>

    <button type="submit" class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
        {{ $vehicle ? 'Mettre à jour' : 'Ajouter' }}
    </button>
</form>
