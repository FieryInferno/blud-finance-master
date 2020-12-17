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
        td { padding: 5px; font-size: 13px; }
		/* .container table, td, th { border: 1px solid black; } */
		/* .container th { background: grey; } */
		.container table { border-collapse: collapse; width: 100%; padding-top: 30px; }
        /* .container table { display: inline-table; } */
        /* th { padding: 8px; font-size: 12.9px; } */
		.content td { padding: 5px; margin-left: 7px; font-size: 11px; vertical-align: top; }
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        .content th { padding: 1px; font-size: 11px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>Rekap {@if (isset($jenis))  SP2B @else SP3B @endif</title>
</head>
<body>
    <div class="container">
        <h2 class="text-center font-weight-bold">
            REKAP @if (isset($jenis))  SP2B @else SP3B @endif<br/>
        </h2>

        <div class="col-print-12">
            <table class="font-weight-bold">
                <tr>
                    <td style="width: 10%;" >Unit Kerja</td>
                    <td style="width: 90%;">: {{ $sp3b->unitKerja->nama_unit }}</td>
                </tr>

                <tr>
                    <td style="width: 10%;">Nomor SP3B</td>
                    <td style="width: 90%;">: {{ $sp3b->nomor }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderAll text-center" width="10%">Nomor</th>
                <th class="borderAll text-center" width="5%">Kode <br/> Kegiatan</th>
                <th class="borderAll text-center" width="15%">Nama Kegiatan</th>
                <th class="borderAll text-center" width="5%">Kode <br/> Kegiatan <br/> APBD</th>
                <th class="borderAll text-center" width="10%">Nama Kegiatan <br/> APBD</th>
                <th class="borderAll text-center" width="5%">Kode Akun</th>
                <th class="borderAll text-center" width="10%">Nama Akun</th>
                <th class="borderAll text-center" width="5%">Kode <br/> Akun <br/> APDB</th>
                <th class="borderAll text-center" width="10%">Nama Akun APDB</th>
                <th class="borderAll text-center" width="10%">Pendapatan</th>
                <th class="borderAll text-center" width="10%">Belanja</th>
            </tr>
            
            @foreach ($allRincianSp3b as $item)
            <tr>
                <td class="borderAll text-left"></td>
                <td class="borderAll text-left">{{ $item['kode_kegiatan'] }}</td>
                <td class="borderAll text-left">{{ $item['nama_kegiatan'] }}</td>
                <td class="borderAll text-left">{{ $item['kode_kegiatan_apbd'] }}</td>
                <td class="borderAll text-left">{{ $item['nama_kegiatan_apbd'] }}</td>
                <td class="borderAll text-left">{{ $item['kode_akun'] }}</td>
                <td class="borderAll text-left">{{ $item['nama_akun'] }}</td>
                <td class="borderAll text-left">{{ $item['kode_akun_apbd'] }}</td>
                <td class="borderAll text-left">{{ $item['nama_akun_apbd'] }}</td>
                <td class="borderAll text-right">{{ format_report($item['pendapatan']) }}</td>
                <td class="borderAll text-right">{{ format_report($item['pengeluaran']) }}</td>
            </tr>
            @endforeach

            <tr>
                <td class="borderLeft text-center font-weight-bold" colspan="5">Jumlah</td>
                <td class="borderNone text-center font-weight-bold" colspan="4"></td>
                <td class="borderAll text-center font-weight-bold">{{ format_report($totalPendapatan) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalPengeluaran) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>