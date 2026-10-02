<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisSampahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_jenis' => ['required', 'string', 'max:100', 'unique:jenis_sampah,nama_jenis'],
            'harga_per_kg' => ['required', 'numeric', 'min:0'],
        ];
    }
}
