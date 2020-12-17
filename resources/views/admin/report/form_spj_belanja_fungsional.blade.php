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
		.content td { padding: 5px; margin-left: 7px; font-size: 10px; }
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
            LAPORAN PERTANGGUNGJAWABAN BENDAHARA PENGELUARAN <br/>
            (SPJ BELANJA - FUNGSIONAL) <br/>
        </p>

        <div class="col-print-12">
            <table>
                <tr>
                    <td style="width: 20%;" class="font-weight-bold">Unit Kerja</td>
                    <td style="width: 80%;" class="font-weight-bold">{{ $unitKerja->kode }} - {{ $unitKerja->nama_unit }}</td>
                </tr>

                <tr>
                    <td style="width: 20%;">Pengguna Anggaran/Kuasa Anggaran</td>
                    <td style="width: 80%;">: -</td>
                </tr>
                
                <tr>
                    <td style="width: 20%;">Bendahara Pengeluaran</td>
                    <td style="width: 80%;">: -</td>
                </tr>

                <tr>
                    <td style="width: 20%;">Tahun Anggaran</td>
                    <td style="width: 80%;">: {{ env('TAHUN_ANGGARAN', 2020) }}</td>
                </tr>

                <tr>
                    <td style="width: 20%;">Kegiatan</td>
                    <td style="width: 80%;">: -</td>
                </tr>

                <tr>
                    <td style="width: 20%;">Keperluan</td>
                    <td style="width: 80%;">: UP/GU/TU</td>
                </tr>

                <tr>
                    <td style="width: 20%;">Tanggal</td>
                    <td style="width: 80%;">:{{ report_date($request->tanggal_awal) }} sampai dengan {{ report_date($request->tanggal_akhir) }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" rowspan="2" style="width: 1%">Kode <br/> Rekening</th>
                <th class="borderLeft text-center" rowspan="2" style="width: 10%;">Uraian</th>
                <th class="borderLeft text-center" rowspan="2">Jumlah <br/> Anggaran</th>
                <th class="borderLeft text-center" colspan="3">SPJ - LS PPKD</th>
                <th class="borderLeft text-center" colspan="3">SPJ - LS Barang &amp; Jasa</th>
                <th class="borderLeft text-center" colspan="3">SPJ - UP/GU/TU</th>
                <th class="borderLeft text-center" rowspan="2">Jumlah SPJ <br/> (LS+UP/GU/TU) <br/> s.d Bulan ini</th>
                <th class="borderLeft text-center" rowspan="2">Sisa Pagu <br/> Anggaran</th>
            </tr>

            <tr>
                <th class="borderAll text-center">s.d Bulan <br/> lalu</th>
                <th class="borderAll text-center">Bulan ini</th>
                <th class="borderAll text-center" style="width: 6%;">s.d Bulan <br/> ini</th>
                <th class="borderAll text-center">s.d Bulan <br/> lalu</th>
                <th class="borderAll text-center">Bulan ini</th>
                <th class="borderAll text-center" style="width: 6%;">s.d Bulan <br/> ini</th>
                <th class="borderAll text-center">s.d Bulan <br/> lalu</th>
                <th class="borderAll text-center">Bulan ini</th>
                <th class="borderAll text-center" style="width: 6%;">s.d Bulan <br/> ini</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6 (4+5)</th>
                <th class="borderAll text-center">7</th>
                <th class="borderAll text-center">8</th>
                <th class="borderAll text-center">9 (7+8)</th>
                <th class="borderAll text-center">10</th>
                <th class="borderAll text-center">11</th>
                <th class="borderAll text-center">12 (10+11)</th>
                <th class="borderAll text-center">13 (6+9+12)</th>
                <th class="borderAll text-center">14 (3-13)</th>
            </tr>

            @php
                $totalAll = $totalPenerimaanPrevious + $totalPenerimaanNow;
            @endphp
            <tr>
                <td class="borderAll text-left" colspan="3">
                    {{ $anggaran->mapKegiatan->blud->kode_bidang }}.{{ $anggaran->mapKegiatan->blud->kode_program }}.{{ $anggaran->mapKegiatan->blud->kode }} {{ $anggaran->mapKegiatan->blud->nama_kegiatan }} - {{ format_report($totalNominal) }}
                </td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right">{{ format_report($totalPenerimaanPrevious) }}</td>
                <td class="borderAll text-right">{{ format_report($totalPenerimaanNow) }}</td>
                <td class="borderAll text-right">{{ format_report($totalAll) }}</td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right">{{ format_report($totalAll) }}</td>
                <td class="borderAll text-center"></td>
            </tr>

            @php
                $totalAnggaran = 0;
                $totalPrevious = 0;
                $totalNow = 0;
                $totalPengeluaranPrevious = 0;
                $totalPengeluaranNow = 0;
            @endphp
            @foreach ($dataAnggaran as $key => $item)
            @php
                $bulanLalu = $item['penerimaan_previous'];
                $bulanIni = $item['penerimaan_now'];
            @endphp
                <tr>
                    <td class="borderAll text-left">{{ $key }}</td>
                    <td class="borderAll text-left">{{ $item['nama_akun'] }}</td>
                    <td class="borderAll text-right">{{ format_report($item['nominal']) }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($bulanLalu) }}</td>
                    <td class="borderAll text-right">{{ format_report($bulanIni) }}</td>
                    <td class="borderAll text-right">{{ format_report($bulanLalu+$bulanIni) }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($bulanLalu+$bulanIni) }}</td>
                    <td class="borderAll text-center"></td>
                </tr>
                @php
                    $totalAnggaran += $item['nominal'];
                    $totalPrevious += $bulanLalu;
                    $totalNow += $bulanIni;
                    $totalPengeluaranPrevious += $item['pengeluaran_previous'];
                    $totalPengeluaranNow += $item['pengeluaran_now'];
                @endphp
            @endforeach
            

            <tr>
                <td class="borderAll font-weight-bold text-center" colspan="2">Jumlah</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalAnggaran) }}</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPrevious) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalNow) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPrevious+$totalNow) }}</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPrevious+$totalNow) }}</td>
                <td class="borderAll font-weight-bold text-center"></td>
            </tr>

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll text-left" colspan="2">Penerimaan:</td>
                <td class="borderAll"></td>
                <td class="borderAll"></td>
                <td class="borderAll"></td>
                <td class="font-weight-bold borderAll">{{ format_report($totalPrevious) }}</td>
                <td class="font-weight-bold borderAll">{{ format_report($totalNow) }}</td>
                <td class="font-weight-bold borderAll">{{ format_report($totalPrevious + $totalNow) }}</td>
                <td class="borderAll"></td>
                <td class="borderAll"></td>
                <td class="borderAll"></td>
                <td class="borderAll">{{ format_report($totalPrevious + $totalNow) }}</td>
                <td class="borderNone"></td>
            </tr>

            @php
                $totalPajakPrevious = 0;
                $totalPajakNow = 0;
            @endphp
            @foreach ($pajak as $itemPajak)
            @php
                $pajakPrevious = isset($pajakPenerimaan['previous'][$itemPajak->kode_pajak]) ? $pajakPenerimaan['previous'][$itemPajak->kode_pajak] : 0;
                $pajakNow = isset($pajakPenerimaan['now'][$itemPajak->kode_pajak]) ? $pajakPenerimaan['now'][$itemPajak->kode_pajak] : 0;
            @endphp
                <tr>
                    <td class="borderNone"></td>
                    <td class="borderAll text-left" colspan="2">- {{ $itemPajak->kode_pajak }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious) }}</td>
                    <td class="borderAll text-right">{{ format_report($pajakNow) }}</td>00</td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious+$pajakNow) }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious+$pajakNow) }}</td>
                    <td class="borderNone"></td>
                </tr>
                @php
                    $totalPajakNow += $pajakNow;
                    $totalPajakPrevious += $pajakPrevious; 
                @endphp
            @endforeach

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll font-weight-bold text-left" colspan="2">Jumlah Penerimaan:</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakPrevious) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakNow) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakPrevious + $totalPajakNow) }}</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakNow + $totalPajakPrevious) }}</td>
                <td class="borderNone"></td>
            </tr>

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll" colspan="2">&nbsp;</td>
                @for ($i = 0; $i < 10; $i++)
                    <td class="borderAll">&nbsp;</td>
                @endfor
                <td class="borderNone"></td>
            </tr>

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll text-left" colspan="2">Pengeluaran:</td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPengeluaranPrevious) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPengeluaranNow) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPengeluaranPrevious + $totalPengeluaranNow) }}</td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right">{{ format_report($totalPengeluaranPrevious + $totalPengeluaranNow) }}</td>
                <td class="borderNone"></td>
            </tr>

            @php
                $totalPajakPrevious = 0;
                $totalPajakNow = 0;
            @endphp
            @foreach ($pajak as $itemPajak)
            @php
                $pajakPrevious = isset($pajakPengeluaran['previous'][$itemPajak->kode_pajak]) ? $pajakPengeluaran['previous'][$itemPajak->kode_pajak] : 0;
                $pajakNow = isset($pajakPengeluaran['now'][$itemPajak->kode_pajak]) ? $pajakPengeluaran['now'][$itemPajak->kode_pajak] : 0;
            @endphp
                <tr>
                    <td class="borderNone"></td>
                    <td class="borderAll text-left" colspan="2">- {{ $itemPajak->kode_pajak }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious) }}</td>
                    <td class="borderAll text-right">{{ format_report($pajakNow) }}</td>00</td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious+$pajakNow) }}</td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right"></td>
                    <td class="borderAll text-right">{{ format_report($pajakPrevious+$pajakNow) }}</td>
                    <td class="borderNone"></td>
                </tr>
                @php
                    $totalPajakNow += $pajakNow;
                    $totalPajakPrevious += $pajakPrevious; 
                @endphp
            @endforeach

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll font-weight-bold text-left" colspan="2">Jumlah Penerimaan:</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakPrevious) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakNow) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakPrevious + $totalPajakNow) }}</td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPajakPrevious + $totalPajakNow) }}</td>
                <td class="borderNone"></td>
            </tr>

            <tr>
                <td class="borderNone"></td>
                <td class="borderAll text-left" colspan="2">Saldo Kas</td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalPrevious-$totalPengeluaranPrevious) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report($totalNow-$totalPengeluaranNow) }}</td>
                <td class="borderAll font-weight-bold text-right">{{ format_report(($totalPrevious-$totalPengeluaranPrevious)+($totalNow-$totalPengeluaranNow)) }}</td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll text-right"></td>
                <td class="borderAll font-weight-bold text-right">{{ format_report(($totalPrevious-$totalPengeluaranPrevious)+($totalNow-$totalPengeluaranNow)) }}</td>
                <td class="borderNone"></td>
            </tr>
            
            <tr>
                <td class="borderNone"></td>
                <td class="borderAll" colspan="2">&nbsp;</td>
                @for ($i = 0; $i < 10; $i++)
                    <td class="borderAll">&nbsp;</td>
                @endfor
                <td class="borderNone"></td>
            </tr>
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui<br/>
                <strong>Pengguna Anggaran/Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd ? $kepalaSkpd->nama_pejabat : '' }}</u> <br/>
                NIP. {{ $kepalaSkpd ? $kepalaSkpd->nip : '' }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                <strong>Bendahara Pengeluaran Pembantu</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPengeluaran ? $bendaharaPengeluaran->nama_pejabat : '' }}</u> <br/>
                NIP. {{ $bendaharaPengeluaran ? $bendaharaPengeluaran->nip : '' }}
            </div>
        </div>
    </div>
</body>
</html>