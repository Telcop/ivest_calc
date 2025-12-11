<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostSharesStoreRequest extends FormRequest
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
            'document.list_quotes.*.prod_code' => 'required|string|min:1|max:10',
            'document.list_quotes.*.prod_name' => 'required|string|min:1|max:250',
            'document.list_quotes.*.date' => 'required|date_format:Y-m-d',
            'document.list_quotes.*.quotes' => 'required|decimal:0,6',
            // 'document.list_quotes.*.name_pif' => 'required|string|min:1|max:250',
            // 'document.list_quotes.*.cost' => 'required|decimal:0,6'
        ];
    }
}
