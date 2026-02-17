<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('total_days');
            $table->unsignedInteger('estimated_total');
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('vehicle_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
