<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('full_name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('license_seniority')->nullable()->after('email');
            $table->unsignedTinyInteger('birth_day')->nullable()->after('license_seniority');
            $table->unsignedTinyInteger('birth_month')->nullable()->after('birth_day');
            $table->unsignedSmallInteger('birth_year')->nullable()->after('birth_month');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'license_seniority', 'birth_day', 'birth_month', 'birth_year']);
        });
    }
};
