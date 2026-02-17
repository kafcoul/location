<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $this->ensureIpNotBlocked();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey(), 300);

            $this->recordFailedAttempt();

            Log::channel('security')->warning('Tentative de connexion échouée', [
                'email' => $this->string('email'),
                'ip' => $this->ip(),
                'user_agent' => $this->userAgent(),
                'attempts' => RateLimiter::attempts($this->throttleKey()),
            ]);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $this->clearFailedAttempts();
        RateLimiter::clear($this->throttleKey());

        Log::channel('security')->info('Connexion réussie', [
            'user_id' => Auth::id(),
            'email' => $this->string('email'),
            'ip' => $this->ip(),
        ]);
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        Log::channel('security')->alert('Compte verrouillé par rate limiting', [
            'email' => $this->string('email'),
            'ip' => $this->ip(),
            'lockout_seconds' => $seconds,
        ]);

        throw ValidationException::withMessages([
            'email' => "Trop de tentatives. Réessayez dans " . ceil($seconds / 60) . " minute(s).",
        ]);
    }

    private function ensureIpNotBlocked(): void
    {
        $ipKey = 'blocked_ip:' . $this->ip();

        if (Cache::has($ipKey)) {
            $remaining = Cache::get($ipKey . ':until', 0) - time();

            throw ValidationException::withMessages([
                'email' => "Votre adresse IP est temporairement bloquée. Réessayez dans " . max(1, ceil($remaining / 60)) . " minute(s).",
            ]);
        }
    }

    private function recordFailedAttempt(): void
    {
        $ipKey = 'failed_attempts_ip:' . $this->ip();
        $emailKey = 'failed_attempts_email:' . Str::lower($this->string('email'));

        $ipAttempts = (int) Cache::get($ipKey, 0) + 1;
        $emailAttempts = (int) Cache::get($emailKey, 0) + 1;

        Cache::put($ipKey, $ipAttempts, 3600);
        Cache::put($emailKey, $emailAttempts, 3600);

        if ($ipAttempts >= 10) {
            $blockDuration = min(3600, $ipAttempts * 60);
            Cache::put('blocked_ip:' . $this->ip(), true, $blockDuration);
            Cache::put('blocked_ip:' . $this->ip() . ':until', time() + $blockDuration, $blockDuration);

            Log::channel('security')->critical('IP bloquée après tentatives multiples', [
                'ip' => $this->ip(),
                'attempts' => $ipAttempts,
                'block_minutes' => $blockDuration / 60,
            ]);
        }

        if ($emailAttempts >= 5) {
            Log::channel('security')->warning('Tentatives multiples sur un email', [
                'email' => $this->string('email'),
                'attempts' => $emailAttempts,
                'ip' => $this->ip(),
            ]);
        }
    }

    private function clearFailedAttempts(): void
    {
        Cache::forget('failed_attempts_ip:' . $this->ip());
        Cache::forget('failed_attempts_email:' . Str::lower($this->string('email')));
        Cache::forget('blocked_ip:' . $this->ip());
        Cache::forget('blocked_ip:' . $this->ip() . ':until');
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')) . '|' . $this->ip());
    }
}
