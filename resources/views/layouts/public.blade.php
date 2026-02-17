<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CKF Motors — Location Premium')</title>
    <meta name="description" content="@yield('meta_description', 'Location de véhicules premium à Abidjan. Paiement sur place.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'CKF Motors — Location Premium')">
    <meta property="og:description" content="@yield('meta_description', 'Location de véhicules premium à Abidjan.')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name" content="CKF Motors">
    <meta property="og:locale" content="fr_CI">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'CKF Motors')">
    <meta name="twitter:description" content="@yield('meta_description', 'Location de véhicules premium à Abidjan.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#c4a35a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="CKF Motors">
    <link rel="apple-touch-icon" href="/images/icons/icon-192.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CKF Logo Animations -->
    <style>
        /* ============================================================
           CKF MOTORS — Animated Premium Logo
           ============================================================ */

        .ckf-logo-link {
            text-decoration: none !important;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .ckf-logo {
            display: inline-flex;
            align-items: baseline;
            gap: 0;
            font-family: 'Montserrat', system-ui, sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            font-size: 20px;
            line-height: 1;
            position: relative;
        }

        .ckf-logo--mobile {
            font-size: 16px;
            letter-spacing: 0.2em;
        }

        .ckf-logo__spacer {
            display: inline-block;
            width: 0.4em;
        }

        /* Each letter */
        .ckf-logo__letter {
            display: inline-block;
            color: #ffffff;
            position: relative;
            animation: ckf-fadeIn 0.6s ease forwards;
            animation-delay: calc(var(--i) * 0.08s);
            opacity: 0;
            transform: translateY(-8px);

            /* Gold shimmer on text */
            background: linear-gradient(
                90deg,
                #ffffff 0%,
                #ffffff 40%,
                #c4a35a 50%,
                #ffffff 60%,
                #ffffff 100%
            );
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: ckf-fadeIn 0.6s ease forwards, ckf-shimmer 4s ease-in-out infinite;
            animation-delay: calc(var(--i) * 0.08s), calc(1s + var(--i) * 0.1s);
        }

        /* MOTORS letters — slightly lighter */
        .ckf-logo__letter--sub {
            font-weight: 300;
            letter-spacing: 0.15em;
            font-size: 0.55em;
            background: linear-gradient(
                90deg,
                rgba(255,255,255,0.7) 0%,
                rgba(255,255,255,0.7) 40%,
                #c4a35a 50%,
                rgba(255,255,255,0.7) 60%,
                rgba(255,255,255,0.7) 100%
            );
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Gold underline that slides in */
        .ckf-logo__line {
            display: block;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c4a35a, transparent);
            margin-top: 6px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hover: expand underline + glow */
        .ckf-logo-link:hover .ckf-logo__line {
            width: 100%;
        }

        .ckf-logo-link:hover .ckf-logo__letter {
            animation: ckf-hoverPulse 0.4s ease forwards, ckf-shimmer 2s ease-in-out infinite;
            animation-delay: calc(var(--i) * 0.03s), 0s;
            text-shadow: 0 0 20px rgba(196, 163, 90, 0.3);
        }

        /* Glow effect on hover */
        .ckf-logo-link::after {
            content: '';
            position: absolute;
            inset: -10px -20px;
            background: radial-gradient(ellipse, rgba(196, 163, 90, 0.08) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
            border-radius: 50%;
        }

        .ckf-logo-link:hover::after {
            opacity: 1;
        }

        /* Keyframes — Letter fade in from top */
        @keyframes ckf-fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-8px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Keyframes — Gold shimmer sweep */
        @keyframes ckf-shimmer {
            0%, 100% {
                background-position: 200% center;
            }
            50% {
                background-position: -200% center;
            }
        }

        /* Keyframes — Hover bounce */
        @keyframes ckf-hoverPulse {
            0% {
                transform: translateY(0) scale(1);
            }
            40% {
                transform: translateY(-2px) scale(1.05);
            }
            100% {
                transform: translateY(0) scale(1);
            }
        }

        /* Scroll shrink effect */
        .navbar-scrolled .ckf-logo {
            font-size: 16px;
            transition: font-size 0.3s ease;
        }

        .navbar-scrolled .ckf-logo--mobile {
            font-size: 14px;
        }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-brand-black text-white font-sans antialiased @yield('body-class')">

        <nav class="fixed top-0 left-0 right-0 z-50 bg-brand-black/90 backdrop-blur-md border-b border-white/5 hidden lg:block" id="navbar">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-3 items-center h-20">

                {{-- Gauche --}}
                <div class="flex items-center space-x-8 justify-self-start">
                    <a href="{{ route('city.show', 'abidjan') }}"
                       class="nav-link {{ request()->is('ville/abidjan*') ? 'active' : '' }}">
                        ABIDJAN
                    </a>
                </div>

                {{-- Centre — Logo toujours centré --}}
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" class="ckf-logo-link group">
                        <span class="ckf-logo" id="ckf-logo">
                            <span class="ckf-logo__letter" style="--i:0">C</span>
                            <span class="ckf-logo__letter" style="--i:1">K</span>
                            <span class="ckf-logo__letter" style="--i:2">F</span>
                            <span class="ckf-logo__spacer"></span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:3">M</span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:4">O</span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:5">T</span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:6">O</span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:7">R</span>
                            <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:8">S</span>
                        </span>
                        <span class="ckf-logo__line"></span>
                    </a>
                </div>

                {{-- Droite --}}
                <div class="flex items-center space-x-8 justify-self-end">
                    <a href="{{ route('accompagnement') }}" class="nav-link {{ request()->routeIs('accompagnement') ? 'active' : '' }}">ACCOMPAGNEMENT</a>
                    <a href="{{ route('faq') }}" class="nav-link {{ request()->routeIs('faq') ? 'active' : '' }}">FAQ</a>

                    @auth
                        @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Support']))
                            <a href="/admin" class="nav-link">ADMIN</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="nav-link">DÉCONNEXION</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">CONNEXION</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

        <div class="fixed top-0 left-0 right-0 z-50 lg:hidden bg-brand-black/95 backdrop-blur-md border-b border-white/5" id="mobile-navbar">
        <div class="flex items-center justify-between px-4 h-16">
            <a href="{{ route('home') }}" class="ckf-logo-link ckf-logo-link--mobile">
                <span class="ckf-logo ckf-logo--mobile">
                    <span class="ckf-logo__letter" style="--i:0">C</span>
                    <span class="ckf-logo__letter" style="--i:1">K</span>
                    <span class="ckf-logo__letter" style="--i:2">F</span>
                    <span class="ckf-logo__spacer"></span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:3">M</span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:4">O</span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:5">T</span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:6">O</span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:7">R</span>
                    <span class="ckf-logo__letter ckf-logo__letter--sub" style="--i:8">S</span>
                </span>
            </a>
            <button id="mobile-menu-btn" class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden bg-brand-black border-t border-white/5 px-4 py-6 space-y-4">
            <a href="{{ route('city.show', 'abidjan') }}" class="block nav-link">ABIDJAN</a>
            <a href="{{ route('accompagnement') }}" class="block nav-link">ACCOMPAGNEMENT</a>
            <a href="{{ route('faq') }}" class="block nav-link">FAQ</a>
            @auth
                @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager', 'Support']))
                    <a href="/admin" class="block nav-link">ADMIN</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block nav-link">DÉCONNEXION</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block nav-link">CONNEXION</a>
            @endauth
        </div>
    </div>

        <div class="h-20"></div>

        @if(session('success'))
        <div class="bg-white/10 border-b border-white/5 text-white px-6 py-3 text-center text-sm tracking-wide">
            {{ session('success') }}
        </div>
    @endif

        <main class="flex-1">
        @yield('content')
    </main>

        <footer class="bg-brand-dark border-t border-white/5 mt-auto">
        <div class="max-w-[1400px] mx-auto px-6 lg:px-12 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">

                                <div>
                    <h4 class="text-xs font-semibold tracking-widest uppercase text-brand-muted mb-6">Localisation</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li>Location de voitures Abidjan</li>
                    </ul>
                </div>

                                <div>
                    <h4 class="text-xs font-semibold tracking-widest uppercase text-brand-muted mb-6">Menu</h4>
                    <ul class="space-y-3 text-sm">
                        <li><a href="{{ route('city.show', 'abidjan') }}" class="text-white/60 hover:text-white transition">Abidjan</a></li>
                        <li><a href="{{ route('accompagnement') }}" class="text-white/60 hover:text-white transition">Accompagnement</a></li>
                        <li><a href="{{ route('faq') }}" class="text-white/60 hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>

                                <div>
                    <h4 class="text-xs font-semibold tracking-widest uppercase text-brand-muted mb-6">Contact</h4>
                    <ul class="space-y-3 text-sm text-white/60">
                        <li class="font-semibold text-white">CKF Motors</li>
                        <li>Abidjan, Côte d'Ivoire</li>
                        <li><a href="mailto:contact@ckfmotors.com" class="hover:text-white transition">contact@ckfmotors.com</a></li>
                    </ul>
                </div>

                                <div class="flex flex-col items-start md:items-end">
                    <a href="{{ route('home') }}" class="text-lg font-bold tracking-[0.2em] uppercase mb-6">CKF MOTORS</a>
                    <div class="flex space-x-4">
                        <a href="#" class="text-white/40 hover:text-white transition" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="text-white/40 hover:text-white transition" aria-label="TikTok">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 0010.86 4.48V13a8.28 8.28 0 005.58 2.17V11.7a4.81 4.81 0 01-3.77-1.84V6.69z"/></svg>
                        </a>
                        <a href="#" class="text-white/40 hover:text-white transition" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

                        <div class="mt-12 pt-8 border-t border-white/5 text-center text-xs text-white/30">
                &copy; {{ date('Y') }} CKF Motors — Location Premium Abidjan. Tous droits réservés.
            </div>
        </div>
    </footer>

        <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            const y = window.scrollY;
            if (y > 50) {
                navbar?.classList.add('navbar-scrolled');
            } else {
                navbar?.classList.remove('navbar-scrolled');
            }
            lastScroll = y;
        }, { passive: true });
    </script>

    <!-- Service Worker PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js').catch(() => {});
        }
    </script>

    @stack('scripts')
</body>
</html>
