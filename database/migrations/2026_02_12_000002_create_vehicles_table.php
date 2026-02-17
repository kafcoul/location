<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('price_per_day');   // en FCFA ou EUR (centimes recommandé)
            $table->unsignedInteger('deposit_amount')->default(0);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['city_id', 'is_available']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
