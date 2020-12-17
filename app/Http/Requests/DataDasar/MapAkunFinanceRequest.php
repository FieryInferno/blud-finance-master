<?php

namespace App\Http\Requests\DataDasar;

use Illuminate\Foundation\Http\FormRequest;

class MapAkunFinanceRequest extends FormRequest
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
            'kode_akun' => 'required',
            'kode_akun_1' => 'nullable',
            'kode_akun_2' => 'nullable',
            'kode_akun_3' => 'nullable',
        ];
    }
}
