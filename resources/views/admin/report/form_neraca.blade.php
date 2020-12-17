<html>
<head>
	<!-- <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-4.3.1.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
	<style>
		body { font-family: "Times New Roman", Times, serif; }
		.col-print-1 {width:8%;  float:left;}
		.col-print-2 {width:16%; float:left;}
		.col-print-3 {width:25%; float:left;}
		.col-print-4 {width:33%; float:left;}
		.col-print-5 {width:42%; float:left;}
		.col-print-6 {width:50%; float:left;}
		.col-print-7 {width:58%; float:left;}
		.col-print-8 {width:66%; float:left;}
		.col-print-9 {width:75%; float:left;}
		.col-print-9{width:83%; float:left;}
		.col-print-11{width:92%; float:left;}
		.col-print-12{width:100%; float:left;}
		.clearfix{clear: both}
		table { width: 100%; }
        td { padding: 5px; font-size: 11px; }
		/* .container table, td, th { border: 1px solid black; } */
		/* .container th { background: grey; } */
		.container table { border-collapse: collapse; width: 100%; padding-top: 0; }
        /* .container table { display: inline-table; } */
        /* th { padding: 8px; font-size: 12.9px; } */
		.content td { padding: 5px; margin-left: 7px; font-size: 11px; vertical-align: top; }
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        .content th { padding: 5px; font-size: 13px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderBottom { border-bottom: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>Neraca</title>
</head>
<body>
    <div class="container">
        <div class="col-print-3 text-center">
            <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div>

        <div class="col-print-7">
            <p class="text-center font-weight-bold">
                DINAS KESEHATAN KOTA MALANG <br/>
                NERACA <br/>
                <small>Untuk Tahun yang Berakhir sampai dengan 31 Desember Tahun {{ env('TAHUN_ANGGARAN', 2020) }} dan Tahun {{ env('TAHUN_ANGGARAN', 2020)-1 }}</small>
            </p>
        </div>

        <div class="clearfix"></div>

        <p class="text-right font-weight-bold">
            <small>(Dalam Rupiah)</small>
        </p>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="5%">No</th>
                <th class="borderLeft borderBottom text-center" width="50%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="20%">{{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderLeft borderBottom text-center" width="20%">{{ env('TAHUN_ANGGARAN', 2020)-1 }}</th>
            </tr>
            <tr>
                <td class="borderLeft text-center">1</td>
                <td class="borderLeft text-left font-weight-bold"><u>ASET</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">2</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">3</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">ASET LANCAR</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">4</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Kas di BLUD</td>
                <td class="borderLeft text-right">{{ format_report($kasNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($kasPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">5</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Kas di PPTK BLUD</td>
                <td class="borderLeft text-right">{{ format_report($kasPPTKNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($kasPPTKPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">6</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Kas Lainnya BLUD</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">7</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Investasi Jangka Pendek Badan Layanan Umum</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">8</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Piutang dari Kegiatan Operasional Badan Layanan Umum</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">9</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Piutang dari Kegiatan Non Operasional Badan Layanan Umum</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">10</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Penyisihan Piutang Tidak Tertagih</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">11</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja di Bayar di muka</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">12</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Uang Muka Belanja</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">13</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Persediaan Badan Layanan Umum</td>
                <td class="borderLeft text-right">{{ format_report($persediaanNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($persediaanPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">14</td>
                <td class="borderLeft text-center font-weight-bold">Total Aset Lancar</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($persediaanNow+$kasNow+$kasPPTKNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($persediaanPrevious+$kasPrevious+$kasPPTKPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">15</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">16</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">ASET TETAP</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">17</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Tanah</td>
                <td class="borderLeft text-right">{{ format_report($tanahNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($tanahPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">18</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Peralatan dan Mesin</td>
                <td class="borderLeft text-right">{{ format_report($peralatanMesinNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($peralatanMesinPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">19</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Gedung dan Bangunan</td>
                <td class="borderLeft text-right">{{ format_report($gedungBangunanNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($gedungBangunanPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">20</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Jalan, Irigasi dan Jaringan</td>
                <td class="borderLeft text-right">{{ format_report($jalanIrigasiNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($jalanIrigasiPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">21</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Aset Tetap Lainnya</td>
                <td class="borderLeft text-right">{{ format_report($asetTetapLainNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($asetTetapLainPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">22</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Konstruksi Dalam Pengerjaan</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">23</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Akumulasi Penyusutan</td>
                <td class="borderLeft text-right">{{ format_report($akumulasiPenyusutanNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($akumulasiPenyusutanPrevious) }}</td>
            </tr>
            @php
                $totalAsetTetapNow = $tanahNow+$peralatanMesinNow+$gedungBangunanNow+$jalanIrigasiNow+$asetTetapLainNow+$akumulasiPenyusutanNow;
                $totalAsetTetapPrevious = $tanahPrevious+$peralatanMesinPrevious+$gedungBangunanPrevious+$jalanIrigasiPrevious+$asetTetapLainPrevious+$akumulasiPenyusutanPrevious;
            @endphp
            <tr>
                <td class="borderLeft text-center">24</td>
                <td class="borderLeft text-center font-weight-bold">Total Aset Tetap</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalAsetTetapNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalAsetTetapPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">25</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">26</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">PIUTANG JANGKA PANJANG</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">27</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Tagihan Penjualan Angsuran</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">28</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Tagihan Penjualan Ganti Rugi</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">29</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Penyisihan Piutang Tidak Tertagih 2</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">30</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Piutang Jangka Panjang</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">31</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">32</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">ASET LAINNYA</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">33</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Kemitraan Dengan Pihak Ketiga</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">34</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Dana Kelolaan</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">35</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Aset yang dibatas Pengelolaannya</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
        </table>

        <p class="text-right font-weight-bold">
            <small>(Dalam Rupiah)</small>
        </p>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="5%">No</th>
                <th class="borderLeft borderBottom text-center" width="50%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="20%">2019</th>
                <th class="borderLeft borderBottom text-center" width="20%">2018</th>
            </tr>
            <tr>
                <td class="borderLeft text-center">36</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Aset Tak Berwujud</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">37</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Aset Lain-lain</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">38</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Akumulasi Amortisasi</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">39</td>
                <td class="borderLeft text-center font-weight-bold">Total Aset Lainnya</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">40</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            @php
                $totalSeluruhAsetNow = $totalAsetTetapNow+$persediaanNow+$kasNow;
                $totalSeluruhAsetPrevious = $totalAsetTetapPrevious+$persediaanPrevious+$kasPrevious;
            @endphp
            <tr>
                <td class="borderLeft text-center">41</td>
                <td class="borderLeft text-center font-weight-bold">TOTAL SELURUH ASET</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalSeluruhAsetNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalSeluruhAsetPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">42</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">60</td>
                <td class="borderLeft text-left font-weight-bold"><u>KEWAJIBAN</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">61</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">62</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">KEWAJIBAN JANGKA PENDEK</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">63</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang Perhitungan Fihak Ketiga</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">64</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang Bunga</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">65</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang Pajak</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">66</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang kepada KUN</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">67</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Bagian Lancar Utang Jangka Panjang</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">68</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja yang masih harus dibayar</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">69</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pendapatan Diterima Dimuka</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">70</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang Jangka Pendek Lainnya</td>
                <td class="borderLeft text-right">{{ format_report($utangJangkaPendekNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($utangJangkaPendekPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">71</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Kewajiban Jangka Pendek</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">72</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 15px;">KEWAJIBAN JANGKA PANJANG</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">73</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Utang Jangka Panjang</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">74</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Kewajiban Jangka Panjang</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">75</td>
                <td class="borderLeft text-center font-weight-bold">JUMLAH KEWAJIBAN</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($utangJangkaPendekNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($utangJangkaPendekPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">76</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">77</td>
                <td class="borderLeft text-left font-weight-bold"><u>EKUITAS</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">78</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Ekuitas</td>
                <td class="borderLeft text-right">{{ format_report($ekuitasNow) }}</td>
                <td class="borderLeft text-right">{{ format_report($ekuitasPrevious) }}</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">79</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">R/K BLUD</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">80</td>
                <td class="borderLeft text-center font-weight-bold">JUMLAH KEWAJIBAN DAN EKUITAS DANA</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($utangJangkaPendekNow+$ekuitasNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($utangJangkaPendekPrevious+$ekuitasPrevious) }}</td>
            </tr>
                        
        </table>

        <div class="footer">
            <div class="col-print-8 text-center"></div>

            <div class="col-print-4 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                Pimpinan BLUD <br/>
                {{ $unitKerja->nama_unit }} <br/>
                Kota Malang <br/>

                <br/><br/><br/>

                <u><b>{{ $kepalaSkpd->nama_pejabat }}</b></u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>
        </div>
    </div>
</body>
</html>