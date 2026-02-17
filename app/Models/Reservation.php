<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Reservation extends Model
{
    use LogsActivity;

    protected $fillable = [
        'vehicle_id',
        'full_name',
        'first_name',
        'last_name',
        'phone',
        'email',
        'license_seniority',
        'birth_day',
        'birth_month',
        'birth_year',
        'start_date',
        'end_date',
        'total_days',
        'estimated_total',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date'      => 'date',
            'end_date'        => 'date',
            'total_days'      => 'integer',
            'estimated_total' => 'integer',
        ];
    }

    /* ---------- constants ---------- */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'vehicle_id', 'start_date', 'end_date', 'estimated_total'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn (string $eventName) => "Réservation {$eventName}");
    }

    public const STATUS_PENDING   = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_CANCELLED,
    ];

    /* ---------- relations ---------- */

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /* ---------- helpers ---------- */

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isConfirmed(): bool
    {
        return $this->status === self::STATUS_CONFIRMED;
    }
}
