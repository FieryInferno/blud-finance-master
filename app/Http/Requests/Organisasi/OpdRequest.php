<?php

namespace App\Http\Requests\Organisasi;

use Illuminate\Foundation\Http\FormRequest;

class OpdRequest extends FormRequest
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
            'nama_pejabat' => 'required',
            'nip' => 'required',
            'jabatan_id' => 'required',
            'kode' => 'nullable|unique:bidang,kode,'.$id,
            'status' => 'nullable'
        ];
    }
}
