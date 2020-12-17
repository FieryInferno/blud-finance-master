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
		.col-print-10{width:83%; float:left;}
		.col-print-11{width:92%; float:left;}
		.col-print-12{width:100%; float:left;}
		.clearfix{clear: both}
		table { width: 100%; }
		/* .container table, td, th { border: 1px solid black; } */
		/* .container th { background: grey; } */
		.container table { border-collapse: collapse; width: 100%; padding-top: 0; }
        /* .container table { display: inline-table; } */
        th { padding: 8px; font-size: 12.9px; }
		td { padding: 5px; margin-left: 7px; font-size: 12px; }
        .data-spd { border: 1px solid black; }
        .data-spd th { background: grey; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 14px; }
        .container ol { padding-left: 0; counter-reset: item; padding-top: 0; }
        .container ol li { display: block; }
        .container ol li:before { 
            content: counter(item) ". ";
            counter-increment: item;
            width: 5px;
        }
    </style>
    <title>FormulirSPD</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            Dinas Kesehatan Kota Malang <br/>
            PEJABAT PENGELOLA KEUANGAN DAERAH BLUD <br/>
            {{ $spd->unitKerja->nama_unit }} <br/>
            NOMOR {{ $spd->nomorfix }} TAHUN {{ env('TAHUN_ANGGARAN', 2020)}} <br/>
            TENTANG <br/>
            SURAT PENYEDIAAN DANA ANGGARAN BELANJA DAERAH TAHUN ANGGARAN {{ env('TAHUN_ANGGARAN', 2020)}} <br/>
        </p>

        <div class="col-print-2 font-weight-bold">
            Menimbang &nbsp; :
        </div>

        <div class="col-print-10 text-left">
            Bahwa untuk melaksanakan anggaran belanja langsung dan belanja tidak langsung tahun anggaran 2019 berdasarkan anggaran kas yang telah ditetapkan, perlu disediakan pendanaan dengan menerbitkan Surat Penyediaan Dana (SPD);
        </div>

        <div class="clearfix"></div>

        <div class="col-print-2 font-weight-bold" style="padding-top: 10px;">
            Mengingat &nbsp; &nbsp; :
        </div>

        <div class="col-print-10">
            <ol>
                <li>Peraturan Daerah  Nomor - Tahun 2018 tentang  Penjabaran Anggaran Pendapatan dan Belanja Daerah Kota Malang Tahun Anggaran 2018</li>
                <li>Peraturan Walikota Nomor - Tahun 2018  tentang Penjabaran Anggaran Pendapatan dan Belanja Daerah Kota Malang Tahun Anggaran 2019</li>
                <li>DPA-SKPD Dinas Kesehatan Kota Malang (Daftar nomor terlampir)</li>    
            </ol>
        </div>

        <div class="clearfix"></div>

        <p class="text-center font-weight-bold">MEMUTUSKAN :</p>
        <p class="text-left">
           @for($i = 1; $i <= 5; $i++) &nbsp; @endfor 
           Berdasarkan Peraturan Daerah Nomor - Tahun 2018, Tentang Anggaran Pendapatan dan Belanja Daerah Tahun Anggaran 2019, menetapkan/menyediakan kredit anggaran sebagai berikut:
        </p>

        <table>
            <tr>
                <td style="width: 3%" class="text-left">1.</td>
                <td style="width: 30%" class="text-left">Ditujukan kepada Unit Kerja</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ $spd->unitKerja->nama_unit }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left">2.</td>
                <td style="width: 30%" class="text-left">Nama Bendahara Pengeluaran</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ $spd->bendaharaPengeluaran->nama_pejabat }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left">3.</td>
                <td style="width: 30%" class="text-left">Jumlah penyedia dana</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">
                    {{ format_idr($spd->total_nominal ) }} <br/>
                    <i>terbilang  ({{ strtolower(terbilang($spd->total_nominal)) }})</i>
                </td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left">4.</td>
                <td style="width: 30%" class="text-left">Untuk Kebutuhan</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">Bulan {{ ucfirst(bulan($spd->bulan_awal)) }} s/d Bulan {{ ucfirst(bulan($spd->bulan_akhir)) }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left">5.</td>
                <td style="width: 30%" class="text-left">Ikhtisar penyediaan data</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left"></td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left"></td>
                <td style="width: 30%" class="text-left">a. Jumlah dana DPA-SPKD/DPPA-SKPD/DPAL-SKPD</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ format_idr($totalAnggaran) }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left"></td>
                <td style="width: 30%" class="text-left">b. Akumulasi SPD sebelumnya</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ format_idr($totalSpdBefore) }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left"></td>
                <td style="width: 30%" class="text-left">c. Sisa dana yang belum di-SPD kan</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ format_idr($totalAnggaran - ($totalSpdBefore + $spd->total_nominal)) }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left"></td>
                <td style="width: 30%" class="text-left">d. Jumlah dana yang di-SPD-kan saat ini</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">{{ format_idr($spd->total_nominal) }}</td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left"></td>
                <td style="width: 30%" class="text-left">e. Sisa jumlah dana DPA-SKPD/DPPA-SKPD/DPAL-SKPD*) yang belumdi-SPD-kan</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">
                    {{ format_idr($totalAnggaran - ($totalSpdBefore + $spd->total_nominal)) }} <br/>
                    <i>terbilang ( {{ strtolower(terbilang($totalAnggaran - ($totalSpdBefore + $spd->total_nominal))) }} )</i>
                </td>
            </tr>

            <tr>
                <td style="width: 3%" class="text-left">6.</td>
                <td style="width: 30%" class="text-left">Ketentuan-ketentuan lain</td>
                <td style="width: 1%" class="text-right">:</td>
                <td style="width: 55%" class="text-left">-</td>
            </tr>
        </table>
        
        <div class="col-print-7"></div>
        <div class="col-print-5 text-center" style="margin-top: 20px;">
            Ditetapkan di Kota Malang <br/>
            pada tanggal {{ report_date($spd->tanggal) }} <br/><br/>
            <strong>Pejabat Penatausahaan Keuangan</strong> <br/>
            <strong>{{ strtoupper($spd->unitKerja->nama_unit) }}</strong> <br/>
            
            <br/><br/><br/>

            <u>{{ strtoupper($spd->kuasaBud->nama_pejabat) }}</u> <br/>
            NIP. {{ strtoupper($spd->kuasaBud->nip) }}
        </div>

        <div class="page-break"></div>

        <div class="text-left font-weight-bold" style="margin-bottom: 30px;">
            LAMPIRAN SPD NOMOR: {{ $spd->nomorfix }}<br/>
            BELANJA LANGSUNG <br/>
            PERIODE BULAN: Bulan {{ ucfirst(bulan($spd->bulan_awal)) }} s/d Bulan {{ ucfirst(bulan($spd->bulan_akhir)) }} <br/>
            TAHUN ANGGARAN: {{ env('TAHUN_ANGGARAN', 2020) }}
        </div>

        <table class="data-spd">
            <tr>
                <th class="borderLeft text-center">Kode Kegiatan</th>
                <th class="borderLeft text-center">Anggaran</th>
                <th class="borderLeft text-center">Akumulasi Pada SPD <br/> Sebelumnya</th>
                <th class="borderLeft text-center">
                    Jumlah Pada SPD <br/> Periode Ini
                </th>
                <th class="borderLeft text-center">Sisa Anggaran</th>
            </tr>

            @foreach ($spd->spdRincian as $item)    
                <tr>
                    <td class="text-left borderLeft">{{ $item->kegiatan->kode_bidang }}.{{ $item->kegiatan->kode_program }}.{{ $item->kode_kegiatan }}</td>
                    <td class="text-right borderLeft">{{ format_report($item->anggaran) }}</td>
                    <td class="text-right borderLeft">{{ format_report($item->spd_sebelumnya) }}</td>
                    <td class="text-right borderLeft">{{ format_report($item->total_spd) }}</td>
                    <td class="text-right borderLeft">{{ format_report($item->anggaran - $item->total_spd) }}</td>
                </tr>
            @endforeach
        </table>

        <table style="margin-top: 30px;">
            
        </table>

        <div class="clearfix"></div>

        <div class="col-print-7"></div>
        <div class="col-print-5 text-center" style="margin-top: 20px;">
            Ditetapkan di Kota Malang <br/>
            pada tanggal {{ report_date($spd->tanggal) }} <br/><br/>
            <strong>Pejabat Penatausahaan Keuangan BLUD</strong> <br/>
            <strong>{{ strtoupper($spd->unitKerja->nama_unit) }}</strong> <br/>
            
            <br/><br/><br/>

            <u>{{ strtoupper($spd->kuasaBud->nama_pejabat) }}</u> <br/>
            NIP. {{ strtoupper($spd->kuasaBud->nip) }}
        </div>
    </div>
</body>
</html>