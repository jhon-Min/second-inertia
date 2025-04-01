<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
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

        $current_id = (request()->route('currency')->id);

        return [
            'code' => "required|string|unique:currencies,code,$current_id",
            'rate' => "required|numeric"
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Currency code is required.',
            'rate.required' => 'Exchange rate is required.',
        ];
    }
}
