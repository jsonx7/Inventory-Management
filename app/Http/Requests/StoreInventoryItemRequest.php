<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authentication handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100', 'unique:inventory_items,sku'],
            'description' => ['nullable', 'string'],
            'measurement_unit_id' => ['required', 'integer', 'exists:measurement_units,id'],
            'current_quantity' => ['required', 'numeric', 'min:0', 'max:999999999999.9999'],
            'minimum_quantity' => ['nullable', 'numeric', 'min:0', 'max:999999999999.9999'],
            'unit_price' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Item name is required.',
            'measurement_unit_id.required' => 'Please select a measurement unit.',
            'measurement_unit_id.exists' => 'Selected measurement unit is invalid.',
            'current_quantity.required' => 'Current quantity is required.',
            'current_quantity.min' => 'Quantity cannot be negative.',
        ];
    }
}
