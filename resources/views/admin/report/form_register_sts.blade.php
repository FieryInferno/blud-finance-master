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
        .page-break-table { page-break-inside: auto; page-break-after: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 12px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
        /* .content tr { page-break-inside: avoid; } */
    </style>
    <title>Register STS</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            Dinas Kesehatan Kota Malang <br/>
            BLUD <br/>
            REGISTER STS <br/>
            Tahun Anggaran {{ env('TAHUN_ANGGARAN', 2020) }} <br/>
        </p>

        <p class="text-center">Periode {{ report_date($request['tanggal_awal']) }} s/d {{ report_date($request['tanggal_akhir']) }}</p>
        
        <div class="clearfix"></div>

        <div class="col-print-3" >
            Bendahara Penerimaan &nbsp; :
        </div>

        <div class="col-print-9 text-left">
            <!-- (bisa dihapus jika tidak dibutuhkan) -->
            -
        </div>

        @php
            $totalPindah = 0;
        @endphp
        @foreach ($dataSts as $groupIndex => $group)
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
                <th class="borderLeft text-center" style="padding: 3px; width: 15%;">Uraian</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 10%;">Jumlah</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 10%;">Penyetor</th>
                <th class="borderLeft text-center" style="padding: 3px; width: 30%;">Keterangan</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6</th>
                <th class="borderAll text-center">7</th>
                <th class="borderAll text-center">8</th>
                <th class="borderAll text-center">9</th>
                <th class="borderAll text-center">10</th>
            </tr>

            <tr>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-center borderAll font-weight-bold">Jumlah dipindahkan</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-right borderAll font-weight-bold">{{ format_report($totalPindah) }}</td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
            </tr>

                @foreach ($group as $index => $item)
                <tr>
                    <th class="borderAll text-center">{{ $index+1 }}</th>
                    <th class="borderAll text-center">{{ $item->nomorfix }}</th>
                    <th class="borderAll text-center">{{ report_tanggal($item->tanggal) }}</th>
                    <th class="borderAll text-center">{{ $item->kode_unit_kerja }}</th>
                    <th class="borderAll text-center">{{ $item->unitKerja->nama_unit }}</th>
                    <th class="borderAll text-center">
                        @foreach ($item->rincianSts as $rincian)
                            {{ $rincian->akun->kode_akun }}<br>
                        @endforeach
                    </th>
                    <th class="borderAll text-center">
                        @foreach ($item->rincianSts as $rincian)
                            {{ $rincian->akun->nama_akun }}<br>
                        @endforeach
                    </th>
                    <th class="borderAll text-center">{{ format_report($item->total_nominal) }}</th>
                    <th class="borderAll text-center">{{ $item->bendaharaPenerima->nama_pejabat }}</th>
                    <th class="borderAll text-center">{{ $item->keterangan }}</th>
                </tr>  
                @php
                    $totalPindah += $item->total_nominal;
                @endphp
                @endforeach
                
                @if (++$groupIndex !== $countStsChunk)
                    <div class="page-break"></div>
                @else
                    <tr>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll"></td>
                        <td class="text-center borderAll font-weight-bold">Jumlah</td>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll"></td>
                        <td class="text-right borderAll font-weight-bold">{{ format_report($totalSts) }}</td>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll"></td>
                    </tr>
                @endif
            </table>
        @endforeach

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui/Menyetujui, <br/>
                <strong>Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd->nama_pejabat }}</u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request['tanggal_pelaporan']) }} <br/>
                <strong>Bendahara Penerimaan Pembantu</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPenerimaan->nama_pejabat }}</u> <br/>
                NIP. {{ $bendaharaPenerimaan->nip }}
            </div>
        </div>
    </div>
</body>
</html>