@extends('errors.layout')

@section('code', '429')
@section('title', 'Trop de requêtes')
@section('description')
    {{ $message ?? 'Vous avez effectué trop de requêtes.' }}
    <br>Veuillez patienter {{ $retryAfter ?? 60 }} secondes avant de réessayer.
@endsection

@section('actions')
    <a href="javascript:location.reload()" class="btn btn-primary" id="retry-btn" style="pointer-events: none; opacity: 0.5;">
        ↻ Réessayer dans <span id="countdown">{{ $retryAfter ?? 60 }}</span>s
    </a>
    <a href="{{ url('/') }}" class="btn btn-secondary">
        ← Retour à l'accueil
    </a>
@endsection

@push('scripts')
<script>
    (function() {
        let seconds = {{ $retryAfter ?? 60 }};
        const btn = document.getElementById('retry-btn');
        const countdown = document.getElementById('countdown');

        const timer = setInterval(function() {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(timer);
                btn.style.pointerEvents = 'auto';
                btn.style.opacity = '1';
                btn.innerHTML = '↻ Réessayer maintenant';
            }
        }, 1000);
    })();
</script>
@endpush
