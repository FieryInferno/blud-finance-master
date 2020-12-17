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
		.content td { padding: 7px; margin-left: 7px; font-size: 11px; vertical-align: top; }
        .content { border: 1px solid black; margin: 15px 0px; }
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
        footer { position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; text-align: center; font-size: 10px; }
        footer .pagenum:before { content: counter(page);}
    </style>
    <title>Realisasi Anggaran</title>
</head>
<body>
    <div class="container">
        <div class="col-print-3 text-center">
            <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div>

        <div class="col-print-7">
            <p class="text-center font-weight-bold">
                PEMERINTAH KOTA MALANG <br/>
                BLUD PUSKESMAS {{ strtoupper($unitKerja->nama_unit) }}<br/>
                LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA <br/>
                <small>Untuk Tahun yang Berakhir Per 31 Desember {{ env('TAHUN_ANGGARAN', 2020) }}</small> <br/>
                <small>( {{ report_date($request->tanggal_awal) }} - {{ report_date($request->tanggal_akhir) }} )</small>
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
                <th class="borderLeft borderBottom text-center" width="30%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="20%">Anggaran {{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderLeft borderBottom text-center" width="20%">Realisasi {{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderLeft borderBottom text-center" width="5%">%</th>
                <th class="borderLeft borderBottom text-center" width="20%">Realisasi {{ env('TAHUN_ANGGARAN', 2020)-1 }}</th>
            </tr>

            {{-- @for ($i = 1; $i <= 5; $i++)
            <tr>
                <td class="borderLeft text-center">{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</td>
                <td class="borderLeft text-left font-weight-bold"><u>PENDAPATAN</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            @endfor --}}

            {{-- 1 --}}
            
            <tr>
                <td class="borderLeft text-center">01</td>
                <td class="borderLeft text-left font-weight-bold"><u>PENDAPATAN</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">02</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pendapatan Asli Daerah</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">03</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pendapatan Pajak Daerah</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">04</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pendapatan Retribusi Daerah</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">05</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pendapatan Hasil Pengelolaan Kekayaan Daerah yang dipisahkan</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">06</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Lain-lain PAD yang sah</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom6) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom6) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">07</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Pendapatan (2 s/d 6)</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($anggaranKolom6) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($realisasiKolom6) }}</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            
            {{-- 1 --}}
            <tr>
                <td class="borderLeft text-center">08</td>
                <td class="borderLeft text-left font-weight-bold"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">09</td>
                <td class="borderLeft text-left font-weight-bold"><u>BELANJA</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">10</td>
                <td class="borderLeft text-left font-weight-bold"><u>    BELANJA OPERASI</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">11</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Pegawai</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">12</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Barang</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom12) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom12) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">13</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Bunga</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">14</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Lain-lain</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">15</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Belanja Operasi (11 s/d 14)</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($anggaranKolom12) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($realisasiKolom12) }}</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">16</td>
                <td class="borderLeft text-center font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">17</td>
                <td class="borderLeft text-left font-weight-bold"><u>BELANJA MODAL</u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">18</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Tanah</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom18) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom18) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">19</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Peralatan dan Mesin</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom19) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom19) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">20</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Gedung dan Bangunan</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom20) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom20) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">21</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Jaringan dan Instalasi</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            
            <tr>
                <td class="borderLeft text-center">22</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Aset Tetep Lainnya</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">23</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Belanja Aset Lainnya</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">24</td>
                <td class="borderLeft text-center font-weight-bold">Jumlah Belanja Modal (18 s/d 23)</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($anggaranKolom20+$anggaranKolom24) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($realisasiKolom20+$realisasiKolom24) }}</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">25</td>
                <td class="borderLeft text-center font-weight-bold">JUMLAH BELANJA (15 + 24)</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($anggaranKolom12+$anggaranKolom20+$anggaranKolom24) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($realisasiKolom12+$realisasiKolom20+$realisasiKolom24) }}</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">26</td>
                <td class="borderLeft text-center font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">27</td>
                <td class="borderLeft text-center font-weight-bold">SURPLUS/DEBIT (07 - 25)</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($anggaranKolom6-($anggaranKolom12+$anggaranKolom20+$anggaranKolom24))) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($realisasiKolom6-($realisasiKolom12+$realisasiKolom20+$realisasiKolom24))) }}</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">28</td>
                <td class="borderLeft text-left font-weight-bold"><u></u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>

        </table>

        <div class="page-break"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="5%">No</th>
                <th class="borderLeft borderBottom text-center" width="30%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="20%">Anggaran {{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderLeft borderBottom text-center" width="20%">Realisasi {{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderLeft borderBottom text-center" width="5%">%</th>
                <th class="borderLeft borderBottom text-center" width="20%">Realisasi {{ env('TAHUN_ANGGARAN', 2020)-1 }}</th>
            </tr>

            {{-- <tr>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-left font-weight-bold"><u></u></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr> --}}

            <tr>
                <td class="borderLeft text-center">29</td>
                <td class="borderLeft text-left font-weight-bold"><u>TRANSFER</u></td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">30</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 30px;">PENERIMAAN PEMBIAYAAN DALAM NEGERI</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">31</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Penggunaan SILPA</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom31) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom31) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">32</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Penerimaan dari Divestasi</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            
            <tr>
                <td class="borderLeft text-center">33</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Penerimaan Kembali Pinjaman kepada Pihak Lain</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">34</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 40px;">Jumlah Penerimaan Pembiayaan dalam Negeri (31 s.d 33)</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom31) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom31) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">35</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 40px;">JUMLAH PENERIMAAN PEMBIAYAAN</td>
                <td class="borderLeft text-right">{{ format_report($anggaranKolom31) }}</td>
                <td class="borderLeft text-right">{{ format_report($realisasiKolom31) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">36</td>
                <td class="borderLeft text-left font-weight-bold"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">37</td>
                <td class="borderLeft text-left font-weight-bold">PENGELUARAN PENGELUARAN PEMBIAYAAN DALAM NEGERI</td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
            </tr>

            <tr>
                <td class="borderLeft text-center">38</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pembayaran Pokok Pinjaman</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">39</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pengeluaran Penyertaan Modal</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>
            
            <tr>
                <td class="borderLeft text-center">40</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">Pemberian Pinjaman kepada Pihak Lain</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">41</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 40px;">Jumlah Pengeluaran Pembiayaan dalam Negeri </td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">42</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 40px;">JUMLAH PENGELUARAN PEMBIAYAAN</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">43</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 40px;">PEMBIAYAAN NETTO</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">44</td>
                <td class="borderLeft text-left font-weight-bold" style="padding-left: 30px;">Sisa Lebih Pembiayaan Anggaran</td>
                <td class="borderLeft text-right">{{ format_report(abs($anggaranKolom6-($anggaranKolom12+$anggaranKolom20+$anggaranKolom24))+$anggaranKolom31) }}</td>
                <td class="borderLeft text-right">{{ format_report(abs($realisasiKolom6-($realisasiKolom12+$realisasiKolom20+$realisasiKolom24))+$realisasiKolom31) }}</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

        </table>

        <div class="footer">
            <div class="col-print-8 text-center"></div>

            <div class="col-print-4 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                Pimpinan BLUD <br/>
                {{ $unitKerja->nama_unit }} <br/>

                <br/><br/><br/>

                <u><b>{{ $kepalaSkpd->nama_pejabat }}</b></u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>
        </div>
    </div>

    <footer>
        <i>Dinas Kesehatan Kota Malang</i>
        <div class="pagenum-container">Halaman ke-<span class="pagenum"></span></div>
    </footer>
</body>
</html>