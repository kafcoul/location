<?php

use Illuminate\Support\Facades\Schedule;

// ── Queue Worker Health ────────────────────────────────────
// Relancer les jobs échoués toutes les heures
Schedule::command('queue:retry all')->hourly();

// Nettoyer les jobs échoués de plus de 7 jours
Schedule::command('queue:prune-failed --hours=168')->daily();

// Nettoyer les batches terminées de plus de 48h
Schedule::command('queue:prune-batches --hours=48')->daily();

// Purger les tokens expirés (sessions, password resets)
Schedule::command('auth:clear-resets')->everyFifteenMinutes();

// Nettoyer les anciens logs d'activité (> 90 jours)
Schedule::command('activitylog:clean --days=90')->weekly();

// Optimisation cache en production
Schedule::command('optimize')->dailyAt('04:00')
    ->environments(['production']);
