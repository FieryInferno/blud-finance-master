<?php

namespace App\Http\Requests\SP3B;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiSp3bRequest extends FormRequest
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
            'id' => 'required',
            'status_verifikasi' => 'required'
        ];
    }
}
