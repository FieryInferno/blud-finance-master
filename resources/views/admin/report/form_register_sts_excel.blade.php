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
		/* .container table, td, th { border: 1px solid black; } */
		/* .container th { background: grey; } */
		.container table { border-collapse: collapse; width: 100%; padding-top: 0; }
        /* .container table { display: inline-table; } */
        /* th { padding: 8px; font-size: 12.9px; } */
		/* td { padding: 5px; margin-left: 7px; font-size: 12px; } */
        .content { border: 1px solid black; margin-bottom: 15px; clear: both; }
        .content th { font-size: 10px; }
        .content td { font-size: 9px; padding: 2px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 12px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>Register STS</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            Dinas Kesehatan Kota Malang <br/>
            BLUD <br/>
            REGISTER STS <br/>
            Tahun Anggaran 2019 <br/>
        </p>

        <p class="text-center">Periode {{ report_date($request->tanggal_awal) }} s/d {{ report_date($request->tanggal_akhir) }}</p>
        
        <div class="clearfix"></div>

        <div class="col-print-3" >
            Bendahara Penerimaan &nbsp; :
        </div>

        <div class="col-print-9 text-left">
            <!-- (bisa dihapus jika tidak dibutuhkan) -->
            -
        </div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" style="padding: 3px; width: 3%;">No</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 5%;">No STS</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 5%;">Tanggal</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 5%;">
                    Kode <br/> Unit <br/> Kerja
                </th>
                <th class="borderLeft text-center" style="padding: 3px; width: 15%;">Nama Unit Kerja</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 10%;">
                    Kode <br/> Rekening
                </th>
                <th class="borderLeft text-center" style="padding: 3px; width: 25%;">Uraian</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 10%;">Jumlah</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 10%;">Penyetor</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 20%;">Keterangan</th>
            </tr>

            @php
             $totalSts = 0;   
            @endphp
            @foreach ($stsRincian as $key => $item)
                <tr>
                    <th class="borderAll text-center">{{ $key+1 }}</th>
                    <th class="borderAll text-center">{{ $item->sts->nomorfix }}</th>
                    <th class="borderAll text-center">{{ $item->sts->tanggal }}</th>
                    <th class="borderAll text-center">{{ $item->sts->kode_unit_kerja }}</th>
                    <th class="borderAll text-center">{{ $item->sts->unitKerja->nama_unit }}</th>
                    <th class="borderAll text-center">{{ $item->kode_akun }}</th>
                    <th class="borderAll text-center">{{ $item->akun->nama_akun }}</th>
                    <th class="borderAll text-center">{{ format_report($item->nominal) }}</th>
                    <th class="borderAll text-center"> </th>
                    <th class="borderAll text-center"> </th>
                </tr>
                @php
                    $totalSts+=$item->nominal;
                @endphp
            @endforeach

            <tr>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-center borderAll font-weight-bold">Jumlah dipindahkan</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-right borderAll font-weight-bold">{{ format_report($totalSts) }}</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
            </tr>

            <tr>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-center borderAll font-weight-bold">Jumlah pindahan</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-right borderAll font-weight-bold">0,00</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
            </tr>
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui/Menyetujui, <br/>
                <strong>Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u></u> <br/>
                NIP. 
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, 22 Januari 2020 <br/>
                <strong>Bendahara Penerimaan Pembantu</strong> <br/>

                <br/><br/><br/>

                <u></u> <br/>
                NIP. 
            </div>
        </div>
    </div>
</body>
</html>