<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSetoranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // exists:nasabah,id_nasabah -> mastiin id yang dikirim beneran ada di tabel nasabah
            'id_nasabah' => ['required', 'integer', 'exists:nasabah,id_nasabah'],
            'id_jenis' => ['required', 'integer', 'exists:jenis_sampah,id_jenis'],
            // min:0.01 -> cegah berat 0 atau negatif
            'berat' => ['required', 'numeric', 'min:0.01'],
        ];
    }
}
