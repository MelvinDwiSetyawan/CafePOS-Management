<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('tables', 'table_number')->ignore($this->route('table')),
            ],
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:available,occupied,reserved',
        ];
    }
}