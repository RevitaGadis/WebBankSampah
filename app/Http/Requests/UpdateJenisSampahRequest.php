<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateJenisSampahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_jenis' => [
                'required', 'string', 'max:100',
                Rule::unique('jenis_sampah', 'nama_jenis')->ignore($this->route('jenis_sampah'), 'id_jenis'),
            ],
            'harga_per_kg' => ['required', 'numeric', 'min:0'],
        ];
    }
}
