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
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        .content th { padding: 1px; font-size: 13px; }
		.content td { padding: 5px; margin-left: 7px; font-size: 11px; vertical-align: top; }
        .content td span { padding: 0 5px; }
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
    </style>
    <title>Penjabaran APBD</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            DINAS KESEHATAN KOTA MALANG <br/>
            PENJABARAN LAPORAN REALISASI ANGGARAN PENDAPATAN DAN BELANJA DAERAH <br/>
            Tahun Anggaran {{ env('TAHUN_ANGGARAN', 2020) }} <br/>
        </p>

        <table>
            <tr>
                <td class="font-weight-bold" style="width: 15%">URUSAN PEMERINTAHAN</td>
                <td class="font-weight-bold" style="width: 10%">: 1.02</td>
                <td class="font-weight-bold" style="width: 75%">KESEHATAN</td>
            </tr>

            <tr>
                <td class="font-weight-bold" style="width: 15%">UNIT KERJA</td>
                <td class="font-weight-bold" style="width: 10%">: 1.02.01.{{ $unitKerja->kode }}</td>
                <td class="font-weight-bold" style="width: 75%">{{ strtoupper($unitKerja->nama_unit) }}</td>
            </tr>
        </table>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft borderBottom text-center" rowspan="2" width="25%">Kode Rekening</th>
                <th class="borderLeft borderBottom text-center" rowspan="2" width="25%">Uraian</th>
                <th class="borderLeft borderBottom text-center" colspan="2" width="20%">Jumlah <br/> (Rp)</th>
                <th class="borderLeft borderBottom text-center" colspan="2" width="20%">Bertambah / <br/> Berkurang</th>
                <th class="borderLeft borderBottom text-center" rowspan="2" width="15%">Penjelasan</th>
            </tr>
            
            <tr>
                <th class="borderLeft borderBottom text-center">Anggaran Setelah <br/> Perubahan</th>
                <th class="borderLeft borderBottom text-center">Realisasi</th>
                <th class="borderLeft borderBottom text-center">(Rp)</th>
                <th class="borderLeft borderBottom text-center">%</th>
            </tr>
            
            <tr>
                <th class="borderLeft borderBottom text-center">1</th>
                <th class="borderLeft borderBottom text-center">2</th>
                <th class="borderLeft borderBottom text-center">3</th>
                <th class="borderLeft borderBottom text-center">4</th>
                <th class="borderLeft borderBottom text-center">5 = 4 - 3</th>
                <th class="borderLeft borderBottom text-center">6</th>
                <th class="borderLeft borderBottom text-center">7</th>
            </tr>
            
            @php
                $totalRealisasiRba1 = 0;
                $totalRealisasiRba2 = 0;
            @endphp
            {{-- Parent Example --}}
            @foreach ($akunRba1 as $key => $item)
            @if ($key == 0)
                @php
                    $totalRealisasiRba1 = isset($realisasi[$item->kode_akun]) ? $realisasi[$item->kode_akun] : 0;
                @endphp
            @endif
            @php
                $rba = isset($reportRba1[$item->kode_akun]) ? $reportRba1[$item->kode_akun] : 0;
                $realisasiRba1 = isset($realisasi[$item->kode_akun]) ? $realisasi[$item->kode_akun] : 0;
            @endphp
                @if ($item->is_parent)
                    <tr>
                        <td class="borderLeft text-left font-weight-bold">
                            <span>1.02</span>
                            <span>1.02.01</span>
                            <span>00</span>
                            <span>00</span>
                            <span>{{ $item->kode_akun }}</span>
                        </td>
                        
                        <td class="borderLeft text-left font-weight-bold">{{ $item->nama_akun }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report($rba) }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report($realisasiRba1) }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report(abs($rba-$realisasiRba1)) }}</td>
                        <td class="borderLeft text-right font-weight-bold"></td>
                        <td class="borderLeft text-left"></td>
                    </tr>
                @else
                    <tr>
                        <td class="borderLeft text-left">
                            <span>1.02</span>
                            <span>1.02.01</span>
                            <span>00</span>
                            <span>00</span>
                            <span>{{ $item->kode_akun }}</span>
                        </td>
                        
                        <td class="borderLeft text-left">{{ $item->nama_akun }}</td>
                        <td class="borderLeft text-right">{{ format_report($rba) }}</td>
                        <td class="borderLeft text-right">{{ format_report($realisasiRba1) }}</td>
                        <td class="borderLeft text-right">{{ format_report(abs($rba-$realisasiRba1)) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-left"></td>
                    </tr>
                @endif
            @endforeach

            {{-- Blank row example without border --}}
            <tr>
                @for ($i = 0; $i < 7; $i++)
                <td class="borderLeft">&nbsp;</td>
                @endfor
            </tr>

            {{-- Counting Example --}}
            <tr>
                <td class="borderAll text-left"></td>
                <td class="borderAll text-right font-weight-bold">JUMLAH PENDAPATAN</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($rba1->total_all) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalRealisasiRba1) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($totalRealisasiRba1-$rba1->total_all)) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-left"></td>
            </tr>

            {{-- Blank row example with border --}}
            <tr>
                @for ($i = 0; $i < 7; $i++)
                <td class="borderAll">&nbsp;</td>
                @endfor
            </tr>

             {{-- Parent Example --}}
            @foreach ($akunRba2 as $key => $item)
            @if ($key == 0)
                @php
                    $totalRealisasiRba2 = isset($realisasi[$item->kode_akun]) ? $realisasi[$item->kode_akun] : 0;
                @endphp
            @endif
            @php
                $rba = isset($reportRba2[$item->kode_akun]) ? $reportRba2[$item->kode_akun] : 0;
                $realisasiRba2 = isset($realisasi[$item->kode_akun]) ? $realisasi[$item->kode_akun] : 0;
            @endphp
                @if ($item->is_parent)
                    <tr>
                        <td class="borderLeft text-left font-weight-bold">
                            <span>1.02</span>
                            <span>1.02.01</span>
                            <span>00</span>
                            <span>00</span>
                            <span>{{ $item->kode_akun }}</span>
                        </td>
                        
                        <td class="borderLeft text-left font-weight-bold">{{ $item->nama_akun }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report($rba) }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report($realisasiRba2) }}</td>
                        <td class="borderLeft text-right font-weight-bold">{{ format_report(abs($rba-$realisasiRba2)) }}</td>
                        <td class="borderLeft text-right font-weight-bold"></td>
                        <td class="borderLeft text-left"></td>
                    </tr>
                @else
                    <tr>
                        <td class="borderLeft text-left">
                            <span>1.02</span>
                            <span>1.02.01</span>
                            <span>00</span>
                            <span>00</span>
                            <span>{{ $item->kode_akun }}</span>
                        </td>
                        
                        <td class="borderLeft text-left">{{ $item->nama_akun }}</td>
                        <td class="borderLeft text-right">{{ format_report($rba) }}</td>
                        <td class="borderLeft text-right">{{ format_report($realisasiRba2) }}</td>
                        <td class="borderLeft text-right">{{ format_report($rba-$realisasiRba2) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-left"></td>
                    </tr>
                @endif
            @endforeach

            {{-- Blank row example without border --}}
            <tr>
                @for ($i = 0; $i < 7; $i++)
                <td class="borderLeft">&nbsp;</td>
                @endfor
            </tr>

            {{-- Counting Example --}}
            <tr>
                <td class="borderAll text-left"></td>
                <td class="borderAll text-right font-weight-bold">JUMLAH BELANJA</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($rba2->total_all) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($totalRealisasiRba2) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($rba2->total_all-$totalRealisasiRba2)) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-left"></td>
            </tr>

            <tr>
                @for ($i = 0; $i < 7; $i++)
                <td class="borderLeft">&nbsp;</td>
                @endfor
            </tr>
            {{-- Footer of this table --}}
            <tr>
                <td class="borderAll text-left"></td>
                <td class="borderAll text-right font-weight-bold">SURPLUS / DEFISIT</td>
                <td class="borderAll text-right font-weight-bold">({{ format_report(abs($rba1->total_all-$rba2->total_all)) }})</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($totalRealisasiRba2-$totalRealisasiRba1)) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs(($rba2->total_all-$totalRealisasiRba2)-($rba1->total_all-$totalRealisasiRba1)))  }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
                <td class="borderAll text-left"></td>
            </tr>
        </table>
    </div>
</body>
</html>