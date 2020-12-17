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
    <title>Laporan Perubahan Ekuitas</title>
</head>
<body>
    <div class="container">
        <div class="col-print-3 text-center">
            <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div>

        <div class="col-print-7">
            <p class="text-center font-weight-bold">
                DINAS KESEHATAN KOTA MALANG <br/>
                {{ $unitKerja->nama_unit }} <br/>
                LAPORAN PERUBAHAN EKUITAS <br/>
                <small>Periode {{ report_date($request->tanggal_awal) }} sampai dengan {{ report_date($request->tanggal_akhir) }}</small>
            </p>
        </div>

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
                <td class="borderLeft text-left">EKUITAS AWAL</td>
                <td class="borderLeft text-right font-weight-bold">{{ format_report($ekuitas) }}</td>
                <td class="borderLeft text-right font-weight-bold">{{ format_report($ekuitas) }}</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">2</td>
                <td class="borderLeft text-left">SURPLUS/DEFISIT-LO</td>
                <td class="borderLeft text-right font-weight-bold">{{ format_report($surplusDefisit) }}</td>
                <td class="borderLeft text-right font-weight-bold">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">3</td>
                <td class="borderLeft text-left">DAMPAK KUMULATIF PERUBAHAN KEBIJAKAN/KESALAHAN MENDASAR :</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">4</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">KOREKSI PENDAPATAN PIUTANG</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">5</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">KOREKSI UTANG</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">6</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">DAMPAK KOMULATIF PERUBAHAN KEB.ASET TETAP</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">7</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">DAMPAK KOMULATIF PERUBAHAN KEB.AK.PENYUSUTAN</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">8</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">KOREKSI PENYUSUTAN S/D 2014</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">9</td>
                <td class="borderLeft text-left" style="padding-left: 30px;">DAMPAK KOMULATIF PERUBAHAN KEB.AKUNTANSI AMORTISASI</td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right">0,00</td>
            </tr>

            <tr>
                <td class="borderLeft text-center">10</td>
                <td class="borderLeft text-left">EKUITAS AKHIR</td>
                <td class="borderLeft text-right font-weight-bold">{{ format_report($ekuitas + $surplusDefisit) }}</td>
                <td class="borderLeft text-right font-weight-bold">{{ format_report($ekuitas) }}</td>
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