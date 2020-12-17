<?php

namespace App\Http\Requests\Akutansi;

use Illuminate\Foundation\Http\FormRequest;

class JurnalPenyesuaianRequest extends FormRequest
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
            'tanggal' => 'required|date',
            'unit_kerja' => 'required',
            'keterangan' => 'required',
            'kode_akun.*' => 'required',
            'debet.*' => 'required',
            'kredit.*' => 'required'
        ];
    }
}
