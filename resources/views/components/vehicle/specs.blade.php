
<div class="vp-specs">
    <div class="vp-specs__item">
        <span class="vp-specs__label">Année</span>
        <span class="vp-specs__value">{{ $vehicle->year ?? '—' }}</span>
    </div>
    <span class="vp-specs__sep"></span>
    <div class="vp-specs__item">
        <span class="vp-specs__label">Boîte de vitesse</span>
        <span class="vp-specs__value">{{ $vehicle->gearbox ?? 'Automatique' }}</span>
    </div>
    <span class="vp-specs__sep"></span>
    <div class="vp-specs__item">
        <span class="vp-specs__label">Puissance</span>
        <span class="vp-specs__value">{{ $vehicle->power ?? '—' }}</span>
    </div>
    <span class="vp-specs__sep"></span>
    <div class="vp-specs__item">
        <span class="vp-specs__label">Places</span>
        <span class="vp-specs__value">{{ $vehicle->seats ?? 5 }}</span>
    </div>
    <span class="vp-specs__sep"></span>
    <div class="vp-specs__item">
        <span class="vp-specs__label">Carburant</span>
        <span class="vp-specs__value">{{ $vehicle->fuel ?? '—' }}</span>
    </div>
    <span class="vp-specs__sep"></span>
    <div class="vp-specs__item">
        <span class="vp-specs__label">CarPlay</span>
        <span class="vp-specs__value">{{ $vehicle->carplay ? 'Oui' : 'Non' }}</span>
    </div>
</div>
