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
		td { padding: 5px; margin-left: 7px; font-size: 12px; }
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        /* .content th { padding: 8px; background: grey; } */
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 14px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>BKU Bendahara</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            Dinas Kesehatan Kota Malang <br/>
            BKU Bendahara <br/>
            Bendahara Pengeluaran <br/>
        </p>
        
        <div class="col-print-2">
            Unit Kerja
        </div>

        <div class="col-print-1 text-right" style="padding-right: 5px;">:</div>

        <div class="col-print-9 text-left">
            {{ $unitKerja->kode }} - {{ $unitKerja->nama_unit }}   
        </div>

        @php
            $penerimaanPindah = 0;
            $pengeluaranPindah = 0;
            $saldoSebelumnya = 0;
            $counter = 0;
        @endphp
        @foreach ($dataBkuPengeluaran as $groupIndex => $group)
        <table class="content">
            <tr>
                <th class="borderLeft text-center" style="padding: 8px; width: 10%;">No</th>
                <th class="borderLeft text-center" style="padding: 8px; width: 15%;">Tanggal</th>
                <th class="borderLeft text-center" style="padding: 8px; width: 30%;">Uraian</th>
                <th class="borderLeft text-center" style="padding: 8px; width: 15%;">Kode Rekening</th>
                <th class="borderLeft text-center" style="padding: 8px; width: 20%;">Penerimaan (Rp)</th>
                <th class="borderLeft text-center" style="padding: 8px; width: 20%;">Pengeluaran (Rp)</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6</th>
            </tr>
            

            <tr>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll font-weight-bold">Jumlah dipindahkan</td>
                <td class="text-left borderAll"></td>
                <td class="text-right borderAll">{{ format_report($penerimaanPindah) }}</td>
                <td class="text-right borderAll">{{ format_report($pengeluaranPindah) }}</td>
            </tr>

            <tr>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll"></td>
                <td class="text-left borderAll font-weight-bold">Saldo sebelumnya</td>
                <td class="text-left borderAll"></td>
                <td class="text-right borderAll"></td>
                <td class="text-right borderAll">({{ format_report($penerimaanPindah - $pengeluaranPindah) }})</td>
            </tr>

            @php
                $counter = 0;
            @endphp
            @foreach ($group as $index => $item)
                
                @if ($item['nomorbku'] != '')
                    <tr>
                        <td class="text-left borderAll">{{ $item['nomorbku'] }}</td>
                        <td class="text-left borderAll">{{ report_date($item['tanggal']) }}</td>
                        <td class="text-left borderAll">{{ $item['uraian'] }}</td>
                        <td class="text-left borderAll"></td>
                        <td class="text-right borderAll">{{ format_idr($item['nominal']) }}</td>
                        <td class="text-right borderAll">{{ format_idr($item['nominal']) }}</td>
                    </tr>
                    @php
                        $penerimaanPindah += $item['nominal'];
                        $pengeluaranPindah += $item['nominal'];
                        $saldoSebelumnya += $item['nominal'];
                    @endphp
                @else 
                    <tr>
                        <td class="text-left borderAll"></td>
                        <td class="text-left borderAll">{{ report_date($item['tanggal']) }}</td>
                        <td class="text-left borderAll">{{ $item['uraian'] }}</td>
                        <td class="text-left borderAll"></td>
                        <td class="text-right borderAll">{{ format_idr($item['nominal']) }}</td>
                        <td class="text-right borderAll">0.00</td>
                    </tr>
                    @php
                        $penerimaanPindah += $item['nominal'];
                        $saldoSebelumnya += $item['nominal'];
                        $penerimaanPreviousMonth = $penerimaanPreviousMonth > 0 ? $penerimaanPreviousMonth - $setorPajakData : 0;
                        $pengeluaranPreviousMonth = $pengeluaranPreviousMonth > 0 ? $pengeluaranPreviousMonth - $setorPajakData : 0;
                    @endphp
                @endif
                @php
                    ++$counter;
                @endphp
            @endforeach
            
            @if (++$groupIndex !== $countBkuPengeluaranChunk)
                <div class="page-break"></div>
            @else
                <tr>
                    <td class="text-left borderAll" colspan="4">Jumlah bulan {{ bulan($firstMonth) }} </td>
                    <td class="text-right borderAll">{{ format_report($penerimaanPindah-$setorPajakData) }}</td>
                    <td class="text-right borderAll">{{ format_report($pengeluaranPindah-$setorPajakData) }}</td>
                </tr>

                <tr>
                    <td class="text-left borderAll" colspan="4">Jumlah bulan lalu</td>
                    <td class="text-right borderAll">{{ format_report($penerimaanPreviousMonth - $setorPajakDataPrevious) }}</td>
                    <td class="text-right borderAll">{{ format_report($pengeluaranPreviousMonth - $setorPajakDataPrevious) }}</td>
                </tr>
                <tr>
                    <td class="text-left borderAll" colspan="4">Jumlah s/d bulan {{ bulan($lastMonth) }}</td>
                    <td class="text-right borderAll">{{ format_report(($penerimaanPindah-$setorPajakData) + ($penerimaanPreviousMonth-$setorPajakDataPrevious)) }}</td>
                    <td class="text-right borderAll">{{ format_report(($pengeluaranPindah-$setorPajakData) + ($pengeluaranPreviousMonth-$setorPajakDataPrevious)) }}</td>
                </tr>

                <tr>
                    <td class="text-left borderAll" colspan="4">Sisa Kas</td>
                    <td class="text-right borderAll" colspan="2"></td>
                </tr>
            @endif
        </table>
        @endforeach
        @if ($counter > 9 && $counter != 12)
            <div class="page-break"></div>
        @endif
        <div class="col-print-12 text-left">
            Pada hari Rabu tanggal {{ report_date($request->tanggal_pelaporan) }} <br/>
            Oleh kami didapat kas sebesar Rp 0,00 <br/>
            <i>(NOL RUPIAH)</i> <br/>
            Terdiri dari <br/>
            <div class="list">
                a. Tunai sebesar Rp. 0,00 <br/>
                b. Saldo bank sebesar Rp. 0,00 <br/>
                c. Surat berharga sebesar <i style="letter-spacing: 3px;">NIHIL</i> <br/>
            </div>
        </div>

        <div class="footer">
            <div class="col-print-6 text-center">
                Mengetahui/Menyetujui, <br/>
                <strong>Pengguna Anggaran/Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepalaSkpd ? $kepalaSkpd->nama_pejabat : '' }}</u> <br/>
                NIP. {{ $kepalaSkpd ? $kepalaSkpd->nip : '' }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }} <br/>
                <strong>Bendahara Pengeluaran</strong> <br/>

                <br/><br/><br/>

                <u>{{ $bendaharaPengeluaran ? $bendaharaPengeluaran->nama_pejabat : '' }}</u> <br/>
                NIP. {{ $bendaharaPengeluaran ? $bendaharaPengeluaran->nip : '' }}
            </div>
        </div>
    </div>
</body>
</html>