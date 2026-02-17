<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public form
    }

    public function rules(): array
    {
        return [
            'vehicle_id'         => 'required|exists:vehicles,id',
            'full_name'          => 'nullable|string|max:255',
            'first_name'         => 'required_without:full_name|string|max:255',
            'last_name'          => 'required_without:full_name|string|max:255',
            'phone'              => 'required|string|max:30',
            'email'              => 'required|email|max:255',
            'license_seniority'  => 'nullable|string|max:50',
            'birth_day'          => 'nullable|integer|min:1|max:31',
            'birth_month'        => 'nullable|integer|min:1|max:12',
            'birth_year'         => 'nullable|integer|min:1920|max:' . (date('Y') - 18),
            'start_date'         => 'required|date|after_or_equal:today',
            'end_date'           => 'required|date|after:start_date',
            'notes'              => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'La date de début doit être aujourd\'hui ou plus tard.',
            'end_date.after'            => 'La date de fin doit être après la date de début.',
            'vehicle_id.exists'         => 'Ce véhicule n\'existe pas.',
        ];
    }
}
