<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|email|unique:hotels,email',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|in:luxury,boutique,budget,business,resort',
            'star_rating' => 'nullable|integer|between:0,5',
            'description' => 'nullable|string|max:5000',
            'address' => 'nullable|string|max:1000',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'active' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Hotel name is required.',
            'location.required' => 'Hotel location is required.',
            'email.required' => 'Hotel email is required.',
            'email.unique' => 'This email is already registered for another hotel.',
            'type.required' => 'Please select a hotel type.',
            'type.in' => 'Invalid hotel type selected.',
            'star_rating.between' => 'Star rating must be between 0 and 5.',
            'images.*.image' => 'All uploaded files must be images.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG, GIF, or WebP format.',
            'images.*.max' => 'Each image must not exceed 5MB.',
            'website.url' => 'Please enter a valid website URL.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->has('active') ? true : false,
            'star_rating' => $this->star_rating ?: 0,
        ]);
    }
}
