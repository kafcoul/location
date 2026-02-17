<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('name');
            $table->string('model')->nullable()->after('brand');
            $table->decimal('km_price', 8, 2)->default(0)->after('deposit_amount');
            $table->unsignedInteger('weekly_price')->default(0)->after('km_price');
            $table->unsignedInteger('monthly_classic_price')->default(0)->after('weekly_price');
            $table->unsignedInteger('monthly_premium_price')->default(0)->after('monthly_classic_price');
            $table->string('year', 4)->nullable()->after('monthly_premium_price');
            $table->string('gearbox')->default('Automatique')->after('year');
            $table->string('power')->nullable()->after('gearbox');
            $table->unsignedTinyInteger('seats')->default(5)->after('power');
            $table->string('fuel')->default('Essence')->after('seats');
            $table->boolean('carplay')->default(true)->after('fuel');
            $table->json('gallery')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'brand', 'model', 'km_price', 'weekly_price',
                'monthly_classic_price', 'monthly_premium_price',
                'year', 'gearbox', 'power', 'seats', 'fuel', 'carplay', 'gallery',
            ]);
        });
    }
};
