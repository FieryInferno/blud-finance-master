<?php

namespace App\Http\Requests\DataDasar;

use Illuminate\Foundation\Http\FormRequest;

class PihakKetigaRequest extends FormRequest
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
            'kode' => 'required|string|unique:pihak_ketiga,kode,'.$id,
            'kode_unit_kerja' => 'required',
            'nama' => 'required|string',
            'nama_perusahaan' => 'required|string',
            'alamat' => 'required|string',
            'nama_bank' => 'required|string',
            'no_rekening' => 'required|string',
            'npwp' => 'required|string'
        ];
    }
}
