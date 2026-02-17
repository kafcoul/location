<x-guest-layout>
    <h2 class="auth-card__title">Créer un compte</h2>
    <p class="auth-card__desc">Rejoignez CKF Motors</p>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="auth-field">
            <label for="name" class="auth-label">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="auth-input" placeholder="Votre nom">
            <x-input-error :messages="$errors->get('name')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="auth-input" placeholder="votre@email.com">
            <x-input-error :messages="$errors->get('email')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="auth-input" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="auth-error" />
        </div>

        <div class="auth-field">
            <label for="password_confirmation" class="auth-label">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="auth-input" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="auth-error" />
        </div>

        <button type="submit" class="auth-btn">
            Créer mon compte
        </button>

        <p class="auth-register">
            Déjà inscrit ?
            <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>
</x-guest-layout>
