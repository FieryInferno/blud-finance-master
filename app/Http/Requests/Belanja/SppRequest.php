<?php

namespace App\Http\Requests\Belanja;

use Illuminate\Foundation\Http\FormRequest;

class SppRequest extends FormRequest
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
        $id = $this->request->get('id');
        return [
            'nomor' => 'nullable',
            'tanggal' => 'required',
            'unit_kerja' => 'required',
            'bast' => 'required',
            'sisa_spd_total' => 'required',
            'sisa_spd_kegiatan' => 'required',
            'sisa_kas' => 'required',
            'sisa_pagu_pengajuan' => 'required',
            'keterangan' => 'required',
            'pihak_ketiga' => 'required',
            'bendahara_pengeluaran' => 'required',
            'pptk' => 'required',
            'akun_bendahara' => 'required',
            'pemimpin_blud' => 'required',
            'nominal_sumber_dana' => 'required',
            'spd_id.*' => 'required',
            'nominal_pajak.*' => 'required'
        ];
    }
}
