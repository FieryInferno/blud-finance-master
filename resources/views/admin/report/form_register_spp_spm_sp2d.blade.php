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
		.content td { padding: 5px; margin-left: 7px; font-size: 10px; vertical-align: top; }
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        .content th { padding: 1px; font-size: 11px; }
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
    <title>Rincian Obyek Belanja Bendahara Pengeluaran</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            PEMERINTAH KOTA MALANG <br/>
            REGISTER SPP/SPM/SP2D <br/>
            Periode {{ report_date($request->tanggal_awal) }} s/d {{ report_date($request->tanggal_akhir) }} <br/>
            SPKD :
        </p>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" width="2%" rowspan="2">No</th>
                <th class="borderLeft borderBottom text-center" width="10%" rowspan="2">Nama SKPD</th>
                <th class="borderLeft borderBottom text-center" width="5%" rowspan="2">Jenis <br> UP/GU/TU/ <br>LS</th>
                <th class="borderLeft borderBottom text-center" width="10%" colspan="2">SPP</th>
                <th class="borderLeft borderBottom text-center" width="10%" colspan="2">SPM</th>
                <th class="borderLeft borderBottom text-center" width="10%" colspan="2">SP2D</th>
                <th class="borderLeft borderBottom text-center" width="10%" rowspan="2">Uraian</th>
                <th class="borderLeft borderBottom text-center" width="8%" rowspan="2">Jumlah</th>
                <th class="borderLeft borderBottom text-center" width="10%" rowspan="2">Keterangan</th>
            </tr>

            <tr>
                <th class="borderAll text-center">Tgl.</th>
                <th class="borderAll text-center">Nomor</th>
                <th class="borderAll text-center">Tgl.</th>
                <th class="borderAll text-center">Nomor</th>
                <th class="borderAll text-center">Tgl.</th>
                <th class="borderAll text-center">Nomor</th>
            </tr>
            @foreach ($sp2d as $key => $item)
                
                <tr>
                    <td class="borderLeft text-center">{{ $key }}</td>
                    <td class="borderLeft text-left">{{ $item->unitKerja->nama_unit }}</td>
                    <td class="borderLeft text-center">LS</td>
                    <td class="borderLeft text-center">{{ report_date($item->tanggal) }}</td>
                    <td class="borderLeft text-left">{{ $item->nomorspp }}</td>
                    <td class="borderLeft text-center">{{ report_date($item->tanggal) }}</td>
                    <td class="borderLeft text-left">{{ $item->nomorspm }}</td>
                    <td class="borderLeft text-center">{{ report_date($item->tanggal) }}</td>
                    <td class="borderLeft text-left">{{ $item->nomorsp2d }}</td>
                    <td class="borderLeft text-left">{{ $item->keterangan }}</td>
                    <td class="borderLeft text-right">{{ format_report($item->nominal_sumber_dana) }}</td>
                    <td class="borderLeft text-left"></td>
                </tr>
            @endforeach
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui<br/>
                <strong>Pengguna Anggaran/Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u><b>{{ $kepalaSkpd->nama_pejabat }}</b></u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                <strong>Bendahara Pengeluaran</strong> <br/>

                <br/><br/><br/>

                <u><b>{{ $bendaharaPengeluaran->nama_pejabat }}</b></u> <br/>
                NIP. {{ $bendaharaPengeluaran->nip }}
            </div>
        </div>
    </div>
</body>
</html>