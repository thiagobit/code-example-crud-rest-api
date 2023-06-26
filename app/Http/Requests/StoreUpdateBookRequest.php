<?php

namespace App\Http\Requests;

use App\Rules\IsbnRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateBookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'isbn' => ['nullable', 'integer', new IsbnRule, 'unique:books'],
            'value' => 'nullable|decimal:0,2|max:999.99',
        ];
    }
}
