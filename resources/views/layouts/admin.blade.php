<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — CKF Motors')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 font-sans antialiased">

    <div class="flex">
                <aside class="w-60 bg-gray-900 text-white min-h-screen p-6 space-y-4 text-sm shrink-0">
            <div class="text-lg font-bold mb-6">🚘 Admin</div>
            <a href="{{ route('admin.dashboard') }}" class="block hover:text-gray-300 {{ request()->routeIs('admin.dashboard') ? 'text-white font-semibold' : 'text-gray-400' }}">📊 Dashboard</a>
            <a href="{{ route('admin.vehicles.index') }}" class="block hover:text-gray-300 {{ request()->routeIs('admin.vehicles.*') ? 'text-white font-semibold' : 'text-gray-400' }}">🚗 Véhicules</a>
            <a href="{{ route('admin.reservations.index') }}" class="block hover:text-gray-300 {{ request()->routeIs('admin.reservations.*') ? 'text-white font-semibold' : 'text-gray-400' }}">📋 Réservations</a>
            <hr class="border-gray-700 my-4">
            <a href="{{ route('home') }}" class="block hover:text-gray-300 text-xs text-gray-400">← Retour au site</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block hover:text-gray-300 text-xs text-gray-400">🔓 Déconnexion</button>
            </form>
        </aside>

                <div class="flex-1 p-8 overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

</body>
</html>
