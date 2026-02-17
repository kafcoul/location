<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Vehicle extends Model
{
    use LogsActivity;

    protected $fillable = [
        'city_id',
        'name',
        'brand',
        'model',
        'slug',
        'price_per_day',
        'deposit_amount',
        'km_price',
        'weekly_price',
        'monthly_classic_price',
        'monthly_premium_price',
        'year',
        'gearbox',
        'power',
        'seats',
        'fuel',
        'carplay',
        'description',
        'details',
        'image',
        'gallery',
        'is_available',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day'          => 'integer',
            'deposit_amount'         => 'integer',
            'km_price'               => 'decimal:2',
            'weekly_price'           => 'integer',
            'monthly_classic_price'  => 'integer',
            'monthly_premium_price'  => 'integer',
            'seats'                  => 'integer',
            'carplay'                => 'boolean',
            'is_available'           => 'boolean',
            'gallery'                => 'array',
            'details'                => 'array',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'brand', 'price_per_day', 'is_available', 'city_id'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => "Véhicule {$eventName}");
    }

    /* ---------- relations ---------- */

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /* ---------- scopes ---------- */

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /* ---------- routing ---------- */

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
