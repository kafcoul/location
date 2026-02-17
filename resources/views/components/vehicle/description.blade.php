
<section class="vp-description">
    <div class="vp-description__container">
        {{-- Description principale --}}
        @if($vehicle->description)
            <div class="vp-description__text">
                {{ $vehicle->description }}
            </div>
        @endif

        {{-- Sections détaillées --}}
        @foreach($details as $sectionTitle => $items)
            <div class="vp-description__section">
                <h5 class="vp-description__section-title">{{ $sectionTitle }}</h5>
                <ul class="vp-description__list">
                    @foreach($items as $item)
                        <li class="vp-description__list-item">
                            <span class="vp-description__bullet"></span>
                            <span>{!! preg_replace('/^([^:]+\s*:)/', '<strong>$1</strong>', e($item)) !!}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</section>
