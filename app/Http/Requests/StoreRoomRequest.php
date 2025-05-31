<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'room_number' => [
                'required',
                'string',
                Rule::unique('rooms', 'room_number')->ignore($this->room?->id),
            ],
            'room_type' => 'required|in:single,double,triple,quad,suite,family',
            'occupancy' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'is_available' => 'nullable|boolean',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'hotel_id.required' => 'A hotel must be selected for this room.',
            'hotel_id.exists' => 'The selected hotel does not exist.',

            'room_number.required' => 'Room number is required.',
            'room_number.unique' => 'This room number is already in use.',

            'room_type.required' => 'Room type is required.',
            'room_type.in' => 'Please select a valid room type (single, double, triple, quad, suite, family).',

            'occupancy.required' => 'Please enter the occupancy capacity.',
            'occupancy.integer' => 'Occupancy must be a whole number.',
            'occupancy.min' => 'Occupancy must be at least 1.',

            'price_per_night.required' => 'Please enter the price per night.',
            'price_per_night.numeric' => 'The price must be a number.',
            'price_per_night.min' => 'The price cannot be negative.',

            'images.*.image' => 'Each uploaded file must be an image.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG, or WebP format.',
            'images.*.max' => 'Each image must not exceed 5MB.',
        ];
    }
}
