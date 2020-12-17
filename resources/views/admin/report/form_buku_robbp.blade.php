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
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>SPJ Pendapatan Fungsional</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            PEMERINTAH KOTA MALANG <br/>
            BUKU PEMBANTU <br/>
            PER RINCIAN OBYEK PENERIMAAN <br/>
        </p>

         <p class="text-center" style="font-size: 12px;">
            <i>Periode {{ report_date($request->tanggal_awal) }} sampai dengan {{ report_date($request->tanggal_akhir) }}</i>
        </p>

        <div class="col-print-12">
            <table>
                <tr>
                    <td style="width: 20%;" >SPKD</td>
                    <td style="width: 80%;">: {{ $unitKerja->nama_unit }}</td>
                </tr>
                
                <tr>
                    <td style="width: 20%;" >Kode Rekening</td>
                    <td style="width: 80%;">: {{ $akun->kode_akun }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;" >Nama Rekening</td>
                    <td style="width: 80%;">: {{ $akun->nama_akun }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;" >Jumlah Anggaran</td>
                    <td style="width: 80%;">: {{ format_idr($totalAnggaran) }}</td>
                </tr>
                <tr>
                    <td style="width: 20%;" >Tahun Anggaran</td>
                    <td style="width: 80%;">: {{ env('TAHUN_ANGGARAN', 2020) }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" width="20%">Tanggal</th>
                <th class="borderLeft text-center" width="10%">Aktivitas</th>
                <th class="borderLeft text-center" width="40%">Uraian</th>
                <th class="borderLeft text-center" width="20%">Penerimaan</th>
                <th class="borderLeft text-center" width="20%">Saldo</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
            </tr>

            @foreach ($bropPenerimaan as $item)
            <tr>
                <td class="borderLeft text-center">{{ report_date($item->bku->tanggal) }}</td>
                <td class="borderLeft text-center" >STS</td>
                <td class="borderLeft text-left">{{ $item->bku->keterangan }}</td>
                <td class="borderLeft text-right">{{ format_report($item->penerimaan) }}</td>
                <td class="borderLeft text-right">{{ format_report($item->penerimaan) }}</td>
            </tr>
            @endforeach

            {{-- <tr>
                <td class="borderAll text-center font-weight-bold" colspan="7">Sisa Anggaran Rekening Rp. 795,00</td>
            </tr> --}}
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui<br/>
                <strong>Pengguna Anggaran/Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd->nama_pejabat }}</u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }}<br/>
                <strong>Bendahara Penerimaan</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPengeluaran->nama_pejabat }}</u> <br/>
                NIP. {{ $bendaharaPengeluaran->nip }}
            </div>
        </div>
    </div>
</body>
</html>