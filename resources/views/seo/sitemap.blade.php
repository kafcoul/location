<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {{-- Accueil --}}
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    {{-- Accompagnement --}}
    <url>
        <loc>{{ route('accompagnement') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    {{-- FAQ --}}
    <url>
        <loc>{{ route('faq') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    {{-- Villes --}}
    @foreach($cities as $city)
    <url>
        <loc>{{ route('city.show', $city->slug) }}</loc>
        <lastmod>{{ $city->updated_at->toW3cString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    {{-- Véhicules --}}
    @foreach($vehicles as $vehicle)
    <url>
        <loc>{{ route('vehicle.show', $vehicle->slug) }}</loc>
        <lastmod>{{ $vehicle->updated_at->toW3cString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach
</urlset>
