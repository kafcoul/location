<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Reservations ──────────────────────────────────────
        Schema::table('reservations', function (Blueprint $table) {
            // Widget stats : WHERE status + agrégation par mois
            $table->index(['status', 'created_at'], 'reservations_status_created_idx');

            // Widget stats : WHERE status + WHERE created_at (mois courant / précédent)
            $table->index(['status', 'estimated_total'], 'reservations_status_total_idx');

            // TopVehiclesChart : GROUP BY vehicle_id + COUNT
            $table->index(['vehicle_id', 'status'], 'reservations_vehicle_status_idx');

            // Filtres / tri par date
            $table->index('created_at', 'reservations_created_at_idx');

            // Filtre / recherche par email
            $table->index('email', 'reservations_email_idx');
        });

        // ── Users ─────────────────────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            // Sparklines / stats : WHERE created_at (mois)
            $table->index('created_at', 'users_created_at_idx');

            // Recherche par email (login, recherche admin)
            $table->index('email_verified_at', 'users_email_verified_idx');
        });

        // ── Activity Log ──────────────────────────────────────
        Schema::table('activity_log', function (Blueprint $table) {
            // Filtres ActivityLogResource
            $table->index(['subject_type', 'event'], 'activity_subject_event_idx');
            $table->index(['causer_type', 'causer_id'], 'activity_causer_idx');
            $table->index('created_at', 'activity_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropIndex('reservations_status_created_idx');
            $table->dropIndex('reservations_status_total_idx');
            $table->dropIndex('reservations_vehicle_status_idx');
            $table->dropIndex('reservations_created_at_idx');
            $table->dropIndex('reservations_email_idx');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_created_at_idx');
            $table->dropIndex('users_email_verified_idx');
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex('activity_subject_event_idx');
            $table->dropIndex('activity_created_at_idx');
            $table->dropIndex('activity_causer_idx');
        });
    }
};
