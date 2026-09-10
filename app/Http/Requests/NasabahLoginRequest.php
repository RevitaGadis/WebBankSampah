<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NasabahLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_nasabah' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
