<x-guest-layout>
    <x-auth-session-status class="auth-status" :status="session('status')" />

    <h2 class="auth-card__title">Connexion</h2>
    <p class="auth-card__desc">Accédez à votre espace CKF Motors</p>

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="auth-input" placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="auth-input" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-options">
            <label class="auth-remember">
                <input type="checkbox" name="remember" class="auth-checkbox">
                <span>Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot">Mot de passe oublié ?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">
            Se connecter
        </button>

        @if (Route::has('register'))
            <p class="auth-register">
                Pas encore de compte ?
                <a href="{{ route('register') }}">Créer un compte</a>
            </p>
        @endif
    </form>
</x-guest-layout>
