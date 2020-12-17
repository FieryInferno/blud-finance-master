<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrefixPenomoran extends Model
{
    /**
     * Table name
     * 
     * @var string
     */
    protected $table = 'prefix_penomoran';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_KONTRA_POS = 'Form Kontra Pos';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_DAFTAR_PENGUJI = 'Form Daftar Penguji';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_BUD = 'Form BUD';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_PEMINDAHBUKUAN = 'Form Pemindahbukuan';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SETORAN_PAJAK = 'Form Setoran Pajak';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SETORAN_SISA_UANG_PERSEDIAAN = 'Form Setoran Sisa Uang Persediaan';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SETORAN_POTONGAN_SP2D = 'Form Setoran Potongan SP2D';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SETORAN_PAJAK_SP2D = 'Form Setoran Pajak SP2D';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SPJ_PENDAPATAN = 'Form SPJ Pendapatan';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_PANJAR = 'Form Panjar';

    /**
     * Form Kontra Pos
     * 
     * @var string
     */
    public const FORMULIR_SPJ_PANJAR = 'Form SPJ Panjar';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_TBP = 'Form TBP';

    /**
     * STS
     * 
     * @var string
     */
    public const FORMULIR_STS = 'Form STS';

    /**
     * Sts NL
     * 
     * @var string
     */
    public const FORMULIR_STSNL = 'Form STS-NL';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SPD = 'Form SPD';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SPP = 'Form SPP';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SPM = 'Form SPM';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SP2D = 'Form SP2D';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_BELANJA = 'Form Belanja';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SPJ_ADMINISTRATIF = 'Form SPJ Administratif';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SETORAN_SISA_PANJAR = 'Form Setoran Sisa Panjar';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_MEMO_PENYESUAIAN = 'Form Memo Penyesuaian';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_VERIFIKASI_SPP = 'Form Verifikasi SPP';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_VERIFIKASI_SPM = 'Form Verifikasi SPM';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_VERIFIKASI_SPJ = 'Form Verifikasi SPJ';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SKPD_SKRD = 'Form SKPD/SKRD';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_BKU_PENGELUARAN = 'BKU Pengeluaran';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_BKU_PENERIMAAN = 'BKU Penerimaan';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_SPJ_FUNGSIONAL = 'Form SPJ Fungsional';
    
    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_PENARIKAN_TUNAI = 'Form Penarikan Tunai';

    /**
     * Tbp
     * 
     * @var string
     */
    public const FORMULIR_PENGEMBALIAN_TUNAI = 'Form Pengembalian Tunai';

    /**
     * Saldo Awal LO
     * 
     * @var string
     */
    public const FORMULIR_SALDOAWAL_LO = 'Form SA-LO';

    /**
     * Saldo Awal Neraca
     * 
     * @var string
     */
    public const FORMULIR_SALDOAWAL_NERACA = 'Form SA-N';


    public const FORMULIR_JURNAL_PENYESUAIAN = 'Form Jurnal Penyesuaian';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'formulir', 'format_penomoran'
    ];
}
