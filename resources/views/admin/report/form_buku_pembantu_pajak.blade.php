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
            BUKU PAJAK <br/>
            BENDAHARA PENGELUARAN <br/>
        </p>

        <div class="col-print-12">
            <table>
                <tr>
                    <td style="width: 10%;" >SPKD</td>
                    <td style="width: 90%;">: 1.02.04 - {{ $unitKerja->nama_unit }}</td>
                </tr>
            </table>
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" width="10%">Tanggal</th>
                <th class="borderLeft text-center" width="15%">No. BKU</th>
                <th class="borderLeft text-center" width="20%">Uraian</th>
                <th class="borderLeft text-center" width="10%">Penerimaan <br/> (Rp)</th>
                <th class="borderLeft text-center" width="10%">Pengeluaran <br/> (Rp)</th>
                <th class="borderLeft text-center" width="10%">Saldo <br/> (Rp)</th>
                <th class="borderLeft text-center" width="10%">Nama Wajib <br/> Pajak</th>
                <th class="borderLeft text-center" width="10%">NPWP</th>
            </tr>

            <tr>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6</th>
                <th class="borderAll text-center">7</th>
                <th class="borderAll text-center">8</th>
            </tr>

            {{-- <tr>
                <td class="borderLeft text-left"></td>
                <td class="borderLeft text-left"></td>
                <td class="borderLeft text-left">Saldo Lalu</td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right">0,00</td>
                <td class="borderLeft text-right"></td>
                <td class="borderLeft text-right"></td>
            </tr> --}}

            @php
                $totalPengeluaran = 0;
                $totalPenerimaan = 0;
            @endphp
            @foreach ($setorPajak as $item)
                <tr>
                    <td class="borderLeft text-center">{{ report_date($item->tanggal) }}</td>
                    <td class="borderLeft text-center">{{ $item->nomorbku }}</td>
                    <td class="borderLeft text-left">{{ $item->uraian }}</td>
                    <td class="borderLeft text-right">{{ format_report($item->penerimaan) }}</td>
                    <td class="borderLeft text-right">{{ format_report($item->pengeluaran) }}</td>
                    <td class="borderLeft text-right">({{ format_report($item->penerimaan-$item->pengeluaran) }})</td>
                    <td class="borderLeft text-right">{{ $item->setorPajak->bast->pihakKetiga->nama }}</td>
                    <td class="borderLeft text-right">{{ $item->npwp }}</td>
                </tr>
                @php
                    $totalPenerimaan += $item->penerimaan;
                    $totalPengeluaran += $item->pengeluaran;
                @endphp
            @endforeach

            <tr>
                <td class="borderAll text-right font-weight-bold" colspan="3">Jumlah</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalPenerimaan) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalPengeluaran) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalPenerimaan - $totalPengeluaran) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>
        </table>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui<br/>
                <strong>Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd->nama_pejabat }}</u> <br/>
                NIP. {{ $kepalaSkpd->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                <strong>Bendahara Pengeluaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPengeluaran->nama_pejabat }}</u> <br/>
                NIP. {{ $bendaharaPengeluaran->nip }}
            </div>
        </div>
    </div>
</body>
</html>