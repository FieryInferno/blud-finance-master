<?php

namespace App\Http\Requests\Organisasi;

use Illuminate\Foundation\Http\FormRequest;

class RekeningBendaharaRequest extends FormRequest
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
            'kode_unit_kerja' => 'required',
            'jenis' => 'required',
            'nama_akun_bendahara' => 'required',
            'kode_akun' => 'required',
            'nama_bank' => 'required',
            'rekening_bank' => 'required',
        ];
    }
}
