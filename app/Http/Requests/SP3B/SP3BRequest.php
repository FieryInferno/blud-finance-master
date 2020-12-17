<?php
namespace App\Http\Requests\SP3B;

use Illuminate\Foundation\Http\FormRequest;

class SP3BRequest extends FormRequest {
    
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
            'nomor' => 'required',
            'tanggal' => 'required',
            'triwulan' => 'required',
            'unit_kerja' => 'required',
            'bendahara_penerimaan' => 'required',
            'bendahara_pengeluaran' => 'required',
            'keterangan' => 'required',
            'pejabat_unit' => 'required'
        ];
    }
}