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
		td { padding: 5px; margin-left: 7px; font-size: 10px; }
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
        .footer { margin-top: 25px; font-size: 15px; clear: both; }
    </style>
    <title>SPJ Pendapatan Fungsional</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            DINAS KESEHATAN KOTA MALANG <br/>
            {{ $unitKerja->nama_unit }} <br/>
            LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENERIMAAN SPKD <br/>
            (SPJ PENDAPATAN - FUNGSIONAL) <br/>
        </p>

        <div class="col-print-2">
            Bulan : {{ bulan($month) }}
        </div>

        <div class="col-print-10 text-right">
            (dalam rupiah)
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" rowspan="2" style="width: 1%">Kode <br/> Rekening</th>
                <th class="borderLeft text-center" rowspan="2" style="width: 10%;">Uraian</th>
                <th class="borderLeft text-center" rowspan="2">Jumlah <br/> Anggaran</th>
                <th class="borderLeft text-center" colspan="3">Sampai dengan Bulan Lalu</th>
                <th class="borderLeft text-center" colspan="3">Bulan Ini</th>
                <th class="borderLeft text-center" colspan="4">Sampai dengan Bulan Ini</th>
            </tr>

            <tr>
                <th class="borderAll text-center">Penerimaan</th>
                <th class="borderAll text-center">Penyetoran</th>
                <th class="borderAll text-center" style="width: 6%;">Sisa</th>
                <th class="borderAll text-center">Penerimaan</th>
                <th class="borderAll text-center">Penyetoran</th>
                <th class="borderAll text-center" style="width: 6%;">Sisa</th>
                <th class="borderAll text-center">Jumlah <br/> Anggaran <br/> yang <br/> Terealisasi</th>
                <th class="borderAll text-center">Jumlah <br/> Anggaran <br/> yang telah <br/> Disetor</th>
                <th class="borderAll text-center" style="width: 6%;">Sisa yang <br/> belum <br/> disetor</th>
                <th class="borderAll text-center">Sisa Anggaran <br/> Belum <br/> Terealisasi</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6</th>
                <th class="borderAll text-center">7</th>
                <th class="borderAll text-center">8</th>
                <th class="borderAll text-center">9</th>
                <th class="borderAll text-center">10</th>
                <th class="borderAll text-center">11</th>
                <th class="borderAll text-center">12</th>
                <th class="borderAll text-center">13</th>
            </tr>

            @php
                $totalAnggaran = 0;
                $totalPendapatanBulanLalu = 0;
                $totalPengeluaranBulanLalu = 0;

                $totalPendapatanBulanIni = 0;
                $totalPengeluaranBulanIni = 0;
                
                $totalAnggaranTerealisasi = 0;
                $totalAnggaranTelahSetor = 0;
                $totalAnggaranBelumSetor = 0;
                $totalSisaAnggaran = 0;
            @endphp
            @foreach ($akun as $item)
            @php
                $jumlahAnggaran = isset($anggaran[$item->kode_akun]) ? $anggaran[$item->kode_akun] : 0;

                $pendapatanBulanLalu = isset($pendapatanPreviousMonth[$item->kode_akun]) ? $pendapatanPreviousMonth[$item->kode_akun] : 0;
                $pengeluaranBulanLalu = isset($pengeluaranPreviousMonth[$item->kode_akun]) ? $pengeluaranPreviousMonth[$item->kode_akun] : 0;
                $sisaBulanLalu = $pengeluaranBulanLalu - $pendapatanBulanLalu;

                $pendapatanBulanIni = isset($pendapatanThisMonth[$item->kode_akun]) ? $pendapatanThisMonth[$item->kode_akun] : 0;
                $pengeluaranBulanIni = isset($pengeluaranThisMonth[$item->kode_akun]) ? $pengeluaranThisMonth[$item->kode_akun] : 0;
                $sisaBulanIni = $pendapatanBulanIni - $pengeluaranBulanIni;

                $anggaranTerealisasi = $pendapatanBulanLalu+$pendapatanBulanIni;
                $anggaranTelahSetor = $pengeluaranBulanLalu+$pengeluaranBulanIni;
                $anggaranBelumSetor = ($pendapatanBulanLalu-$pengeluaranBulanLalu) + ($pendapatanBulanIni-$pengeluaranBulanIni);
                $sisaAnggaran = $jumlahAnggaran-$anggaranBelumSetor;

                $totalAnggaran += $jumlahAnggaran;
                $totalPendapatanBulanLalu += $pendapatanBulanLalu;
                $totalPengeluaranBulanLalu += $pengeluaranBulanLalu;

                $totalPendapatanBulanIni += $pendapatanBulanIni;
                $totalPengeluaranBulanIni += $pengeluaranBulanIni;

                $totalAnggaranTerealisasi += $anggaranTerealisasi;
                $totalAnggaranTelahSetor += $anggaranTelahSetor;
                $totalAnggaranBelumSetor += $anggaranBelumSetor;
                $totalSisaAnggaran += $sisaAnggaran;

            @endphp
                <tr>
                    <td class="borderAll text-center">{{ $item->kode_akun }}</td>
                    <td class="borderAll text-center">{{ $item->nama_akun }}</td>
                    <td class="borderAll text-right">{{ format_report($jumlahAnggaran) }}</td>
                    <td class="borderAll text-right">{{ format_report($pendapatanBulanLalu) }}</td>
                    <td class="borderAll text-right">{{ format_report($pengeluaranBulanLalu) }}</td>
                    <td class="borderAll text-right">{{ format_report($sisaBulanLalu) }}</td>
                    <td class="borderAll text-right">{{ format_report($pendapatanBulanIni) }}</td>
                    <td class="borderAll text-right">{{ format_report($pengeluaranBulanIni) }}</td>
                    <td class="borderAll text-right">{{ format_report($sisaBulanIni) }}</td>
                    <td class="borderAll text-right">{{ format_report($anggaranTerealisasi) }}</td>
                    <td class="borderAll text-right">{{ format_report($anggaranTelahSetor) }}</td>
                    <td class="borderAll text-right">{{ format_report($anggaranBelumSetor) }}</td>
                    <td class="borderAll text-right">{{ format_report($sisaAnggaran) }}</td>
                </tr>
            @endforeach

            <tr>
                <td></td>
                <td class="borderAll font-weight-bold text-center">Jumlah</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalAnggaran) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPendapatanBulanLalu) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPengeluaranBulanLalu) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPendapatanBulanLalu - $totalPengeluaranBulanLalu) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPendapatanBulanIni) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPengeluaranBulanIni) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPendapatanBulanIni - $totalPengeluaranBulanIni) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalAnggaranTerealisasi) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalAnggaranTelahSetor) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalAnggaranBelumSetor) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalSisaAnggaran) }}</td>
            </tr>
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                <br/>
                <strong>Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd->nama_pejabat }}</u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }}  <br/>
                <strong>Bendahara Penerimaan Pembantu</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPenerimaan->nama_pejabat }}</u> <br/>
                NIP. {{ $bendaharaPenerimaan->nip }}
            </div>
        </div>
    </div>
</body>
</html>