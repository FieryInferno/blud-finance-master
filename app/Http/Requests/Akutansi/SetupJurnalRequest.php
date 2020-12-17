<?php

namespace App\Http\Requests\Akutansi;

use Illuminate\Foundation\Http\FormRequest;

class SetupJurnalRequest extends FormRequest
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
            'kode_jurnal' => 'required',
            'formulir' => 'required',
            'keterangan' => 'required',
            'rincian_anggaran.*' => 'nullable',
            'jenis_anggaran.*' => 'nullable',
            'nominal_anggaran.*' => 'nullable',
            'rincian_finansial.*' => 'nullable',
            'jenis_finansial.*' => 'nullable',
            'nominal_finansial.*' => 'nullable'
        ];
    }
}
