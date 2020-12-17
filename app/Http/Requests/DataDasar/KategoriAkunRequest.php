<?php

namespace App\Http\Requests\DataDasar;

use Illuminate\Foundation\Http\FormRequest;

class KategoriAkunRequest extends FormRequest
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
            'kode' => 'required|unique:kategori_akun,kode,'.$id,
            'nama_akun' => 'required',
            'saldo_normal' => 'required'
        ];
    }
}
