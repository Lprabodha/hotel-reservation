<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|unique:rooms,room_number',
            'room_type' => 'required|in:single,double,triple,quad,suite,family',
            'occupancy' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }
}
