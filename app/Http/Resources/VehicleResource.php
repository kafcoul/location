<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'brand'                 => $this->brand,
            'model'                 => $this->model,
            'slug'                  => $this->slug,
            'year'                  => $this->year,
            'gearbox'               => $this->gearbox,
            'power'                 => $this->power,
            'seats'                 => $this->seats,
            'fuel'                  => $this->fuel,
            'carplay'               => $this->carplay,
            'description'           => $this->description,
            'details'               => $this->details,
            'is_available'          => $this->is_available,
            'image'                 => $this->image ? asset('storage/' . $this->image) : null,
            'gallery'               => collect($this->gallery ?? [])->map(fn ($img) => asset('storage/' . $img)),
            'pricing' => [
                'price_per_day'         => $this->price_per_day,
                'km_price'              => $this->km_price,
                'deposit_amount'        => $this->deposit_amount,
                'weekly_price'          => $this->weekly_price,
                'monthly_classic_price' => $this->monthly_classic_price,
                'monthly_premium_price' => $this->monthly_premium_price,
            ],
            'city' => [
                'id'   => $this->city?->id,
                'name' => $this->city?->name,
                'slug' => $this->city?->slug,
            ],
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
