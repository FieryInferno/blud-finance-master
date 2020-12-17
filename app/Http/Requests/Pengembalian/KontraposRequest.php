<?php

namespace App\Http\Requests\Pengembalian;

use Illuminate\Foundation\Http\FormRequest;

class KontraposRequest extends FormRequest
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
            'unit_kerja' => 'required',
            'keterangan' => 'required',
            'rekening_bendahara' => 'required|numeric',
            'sp2d_id.*' => 'required',
            'kegiatan_id.*' => 'required',
            'nominal.*' => 'required'
        ];
    }
}
