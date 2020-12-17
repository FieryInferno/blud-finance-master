<?php

namespace App\Http\Requests\Belanja;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiSppRequest extends FormRequest
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
            'id' => 'required',
            'status_verifikasi' => 'required',
            // 'no_billing' => 'nullable|min:8'
        ];
    }
}
