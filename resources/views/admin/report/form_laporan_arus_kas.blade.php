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
		.content td { padding: 3px; margin-left: 7px; font-size: 11px; vertical-align: top; }
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
    <title>Laporan Arus Kas</title>
</head>
<body>
    <div class="container">
        <div class="col-print-2 text-center">
            {{-- <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt=""> --}}
        </div>

        <div class="col-print-8">
            <p class="text-center font-weight-bold">
                PEMERINTAH KOTA MALANG <br/>
                LAPORAN ARUS KAS <br/>
                BLUD {{ $unitKerja->nama_unit }} <br/>
                <small>UNTUK PERIODE YANG BERAKHIR SAMPAI DENGAN 31 DESEMBER {{ env('TAHUN_ANGGARAN', 2020) }} DAN {{ env('TAHUN_ANGGARAN', 2020)-1 }}</small> <br/>
                <small>METODE LANGSUNG</small>
            </p>
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="5%">No</th>
                <th class="borderLeft borderBottom text-center" width="40%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="5%">CaLK</th>
                <th class="borderLeft borderBottom text-center" width="20%">{{ env('TAHUN_ANGGARAN', date('Y')) }}</th>
                <th class="borderLeft borderBottom text-center" width="20%">{{ env('TAHUN_ANGGARAN', date('Y'))-1 }}</th>
            </tr>

            <tr>
                <td class="borderLeft text-center">1</td>
                <td class="borderLeft text-left font-weight-bold"><i>Arus Kas dari Aktivitas Operasi</i></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">2</td>
                <td class="borderLeft text-left font-weight-bold">Arus Masuk Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">3</td>
                <td class="borderLeft text-left">Pendapatan APBD</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">4</td>
                <td class="borderLeft text-left">Pendapatan Jasa Layanan dari Masyarakat</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">{{ format_idr($kolom4) }}</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">5</td>
                <td class="borderLeft text-left">Pendapatan Jasa Layanan dari Entitas Akuntansi/Entitas Pelaporan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">6</td>
                <td class="borderLeft text-left">Pendapatan Hasil Kerja Sama</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">7</td>
                <td class="borderLeft text-left">Pendapatan Hibah</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">8</td>
                <td class="borderLeft text-left">Pendapatan Usaha Lainnya</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">9</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Masuk Kas (3 s.d 8)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom4) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">10</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">11</td>
                <td class="borderLeft text-left font-weight-bold">Arus Keluar Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">12</td>
                <td class="borderLeft text-left">Pembayaran Pegawai</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">13</td>
                <td class="borderLeft text-left">Pembayaran Jasa</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">{{ format_idr($kolom13) }}</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">14</td>
                <td class="borderLeft text-left">Pembayaran Pemeliharaan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">15</td>
                <td class="borderLeft text-left">Pembayaran Langganan Daya dan Jasa</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">16</td>
                <td class="borderLeft text-left">Pembayaran Perjalanan Dinas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">17</td>
                <td class="borderLeft text-left">Pembayaran Bunga</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">18</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Keluar Kas (12 s.d 17)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom13) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">19</td>
                <td class="borderAll text-left font-weight-bold">Arus Kas Bersih dari Aktivitas Operasi (9-18)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom4+$kolom13) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">20</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">21</td>
                <td class="borderLeft text-left font-weight-bold">Arus Kas dari Aktivitas Investasi</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">22</td>
                <td class="borderLeft text-left font-weight-bold">Arus Masuk Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">23</td>
                <td class="borderLeft text-left">Penjualan atas Tanah</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">24</td>
                <td class="borderLeft text-left">Penjualan atas Peralatan dan Mesin</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">25</td>
                <td class="borderLeft text-left">Penjualan atas Gedung dan Bangunan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">26</td>
                <td class="borderLeft text-left">Penjualan atas Jalan, Irigasi dan Bangunan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">27</td>
                <td class="borderLeft text-left">Penjualan Aset Tetap Lainnya</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">28</td>
                <td class="borderLeft text-left">Penjualan Aset Lainnya</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">29</td>
                <td class="borderLeft text-left">Penerimaan dari Divestasi</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">30</td>
                <td class="borderLeft text-left">Penerimaan Penjualan Investasi dalam Bentuk Sekuritas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">31</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Masuk Kas (23 s.d 30)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">32</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">33</td>
                <td class="borderLeft text-left font-weight-bold">Arus Keluar Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">34</td>
                <td class="borderLeft text-left">Perolehan Tanah</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">{{ format_idr($kolom34) }}</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">35</td>
                <td class="borderLeft text-left">Perolehan Peralatan dan Mesin</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">{{ format_idr($kolom35) }}</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">36</td>
                <td class="borderLeft text-left">Perolehan Gedung dan Bangunan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">{{ format_idr($kolom36) }}</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">37</td>
                <td class="borderLeft text-left">Perolehan Jalan, Irigasi dan Bangunan</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">38</td>
                <td class="borderLeft text-left">Perolehan Aset Tetap Lainnya</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">39</td>
                <td class="borderLeft text-left">Perolehan Aset Lainnya</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">40</td>
                <td class="borderLeft text-left">Pengeluran Penyertaan Modal</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">41</td>
                <td class="borderLeft text-left">Pengeluaran Pembelian Investasi dalam Bentuk Sekuritas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">42</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Keluar Kas (34 s.d 41)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom34+$kolom35+$kolom36) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">43</td>
                <td class="borderAll text-left font-weight-bold">Arus Kas Bersih dari Aktivitas Investasi (31-42)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom34+$kolom35+$kolom36) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
        </table>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="5%">No</th>
                <th class="borderLeft borderBottom text-center" width="40%">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="5%">CaLK</th>
                <th class="borderLeft borderBottom text-center" width="20%">2019</th>
                <th class="borderLeft borderBottom text-center" width="20%">2018</th>
            </tr>
            <tr>
                <td class="borderLeft text-center">44</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">45</td>
                <td class="borderLeft text-left font-weight-bold"><i>Arus Kas dari Aktivitas Pendanaan</i></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">46</td>
                <td class="borderLeft text-left font-weight-bold">Arus Masuk Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">47</td>
                <td class="borderLeft text-left">Penerimaan Pinjaman</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">48</td>
                <td class="borderLeft text-left">Penerimaan Kembali Pinjaman kepada Pihak Lain</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">49</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Masuk Kas (47 s.d 48)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">50</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">51</td>
                <td class="borderLeft text-left font-weight-bold">Arus Keluar Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">52</td>
                <td class="borderLeft text-left">Pembayaran Pokok Pinjaman</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">53</td>
                <td class="borderLeft text-left">Pemberian Pinjaman kepada Pihak Lain</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">54</td>
                <td class="borderLeft text-left">Penyetoran ke Kas Daerah</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">55</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Keluar Kas (52 s.d 54)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">56</td>
                <td class="borderAll text-left font-weight-bold">Arus Kas Bersih dari Aktivitas Pendanaan (49-55)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">57</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">58</td>
                <td class="borderLeft text-left font-weight-bold">Arus Kas dari Aktivitas Transitoris</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">59</td>
                <td class="borderLeft text-left font-weight-bold">Arus Masuk Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">60</td>
                <td class="borderLeft text-left">Penerimaan Perhitungan Fihak Ketiga</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-right">-</td>
                <td class="borderLeft text-right">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">61</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Masuk Kas (60)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">62</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
                <td class="borderLeft">&nbsp;</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">63</td>
                <td class="borderLeft text-left font-weight-bold">Arus Keluar Kas</td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
                <td class="borderLeft text-center"></td>
            </tr>
            <tr>
                <td class="borderLeft text-center">64</td>
                <td class="borderAll text-left font-weight-bold">Pengeluaran Perhitungan Fihak Ketiga (PFK)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">65</td>
                <td class="borderAll text-left font-weight-bold">Jumlah Arus Keluar Kas (64)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">66</td>
                <td class="borderAll text-left font-weight-bold">Arus Kas Bersih dari Aktivitas Transitoris (61-65)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">67</td>
                <td class="borderAll text-left font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">68</td>
                <td class="borderAll text-left font-weight-bold">Kenaikan/Penurunan Kas dan Setara Kas BLU (19+43+56+66)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom4+$kolom13+$kolom34+$kolom35+$kolom36) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">69</td>
                <td class="borderAll text-left font-weight-bold">Saldo Awal Kas dan Setara Kas BLU</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom69) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">70</td>
                <td class="borderAll text-left font-weight-bold">Saldo Akhir Kas dan Setara Kas BLU (68+69)</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">{{ format_idr($kolom4+$kolom13+$kolom34+$kolom35+$kolom36+$kolom69) }}</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">71</td>
                <td class="borderAll text-left font-weight-bold">Saldo Akhir Kas di Bendahara Penerimaan</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
            </tr>
            <tr>
                <td class="borderLeft text-center">72</td>
                <td class="borderAll text-left font-weight-bold">Saldo Akhir Kas</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold">0,00</td>
                <td class="borderAll text-right font-weight-bold">-</td>
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