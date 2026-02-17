<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'full_name'       => $this->full_name,
            'phone'           => $this->phone,
            'email'           => $this->email,
            'start_date'      => $this->start_date?->format('Y-m-d'),
            'end_date'        => $this->end_date?->format('Y-m-d'),
            'total_days'      => $this->total_days,
            'estimated_total' => $this->estimated_total,
            'status'          => $this->status,
            'notes'           => $this->notes,
            'vehicle'         => new VehicleResource($this->whenLoaded('vehicle')),
            'created_at'      => $this->created_at?->toISOString(),
        ];
    }
}
