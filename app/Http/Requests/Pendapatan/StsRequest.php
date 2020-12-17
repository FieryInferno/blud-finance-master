<?php

namespace App\Http\Requests\Pendapatan;

use Illuminate\Foundation\Http\FormRequest;

class StsRequest extends FormRequest
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
            'tanggal' => 'required',
            'unit_kerja' => 'required',
            'keterangan' => 'required',
            'rekening_bendahara' => 'required',
            'bendahara_penerima' => 'required',
            'kepala_skpd' => 'required',
            'kode_akun.*' => 'required',
            'tarif.*' => 'required',
            'sumber_dana.*' => 'required',
            'nominal.*' => 'required',
        ];
    }
}
