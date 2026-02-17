
<div class="vp-gallery" id="vehicleGallery">
    <div class="vp-gallery__viewport">
        @if(count($allImages) > 0)
            @foreach($allImages as $i => $src)
                <img src="{{ $src }}"
                     alt="{{ $vehicle->name }}"
                     class="vp-gallery__img {{ $i === 0 ? 'is-active' : '' }}"
                     data-index="{{ $i }}"
                     loading="{{ $i === 0 ? 'eager' : 'lazy' }}">
            @endforeach
        @else
            <div class="vp-gallery__placeholder">
                <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:0.08">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        @if(count($allImages) > 1)
            <button class="vp-gallery__arrow vp-gallery__arrow--prev" data-dir="prev" aria-label="Image précédente">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button class="vp-gallery__arrow vp-gallery__arrow--next" data-dir="next" aria-label="Image suivante">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div class="vp-gallery__dots">
                @foreach($allImages as $i => $src)
                    <button class="vp-gallery__dot {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}"></button>
                @endforeach
            </div>
        @endif
    </div>
</div>
