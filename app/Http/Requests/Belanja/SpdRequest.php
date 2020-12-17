<?php

namespace App\Http\Requests\Belanja;

use Illuminate\Foundation\Http\FormRequest;

class SpdRequest extends FormRequest
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
            'triwulan' => 'required',
            'bulan_awal' => 'required',
            'bulan_akhir' => 'required',
            'unit_kerja' => 'required',
            'keterangan' => 'required',
            'nomor_dpa' => 'required',
            'bendahara_pengeluaran' => 'required',
            'kuasa_bud' => 'required',
        ];
    }
}
