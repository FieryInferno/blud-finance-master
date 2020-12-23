<?php

namespace App\Http\Requests\Belanja;

use Illuminate\Foundation\Http\FormRequest;

class BastRequest extends FormRequest
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
            'nomor'                     => 'required|unique:bast,nomor,'.$id,
            'nomor_kontrak'             => 'required',
            'tanggal_kontrak'           => 'required', 
            'nomor_pemeriksaan'         => 'required', 
            'tanggal_pemeriksaan'       => 'required', 
            'nomor_penerimaan'          => 'required', 
            'tanggal_penerimaan'        => 'required', 
            'nominal_kontrak'           => 'required',
            'unit_kerja'                => 'required',
            'pihak_ketiga'              => 'required',
            'subKegiatan'               => 'required',
            'pejabat_pembuat_komitmen'  => 'required',
            'kode_akun.*'               => 'required',
            'uraian.*'                  => 'required',
            'satuan.*'                  => 'required',
            'unit.*'                    => 'required',
            'harga.*'                   => 'required',
            'bukti_transaksi.*'         => 'nullable',
            'kondisi.*'                 => 'nullable',
        ];
    }
}
