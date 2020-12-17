<?php

namespace App\Http\Requests\Bku;

use Illuminate\Foundation\Http\FormRequest;

class BkuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tanggal_bku' => 'required', 
            'unit_kerja' => 'required', 
            'keterangan' => 'required',
            'no_aktivitas.*' => 'required',
            'tipe.*' => 'required',
            'tanggal.*' => 'required',
            'penerimaan.*' => 'required',
            'pengeluaran.*' => 'required',
            'kode_unit_kerja.*' => 'required',
        ];
    }
}
