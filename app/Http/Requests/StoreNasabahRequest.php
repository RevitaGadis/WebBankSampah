<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNasabahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'kelas' => ['required', 'string', 'max:30'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'pin' => ['required', 'digits_between:4,6'],
        ];
    }
}
