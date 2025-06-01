<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TravelCompanyRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'contact_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',

        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'The company name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'contact_number.string' => 'The phone number must be a string.',
            'contact_number.max' => 'The phone number may not be greater than 20 characters.',
            'address.string' => 'The address must be a string.',
            'address.max' => 'The address may not be greater than 255 characters.',
        ];
    }
}
