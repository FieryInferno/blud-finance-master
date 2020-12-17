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
		.content td { padding: 3px; margin-left: 7px; font-size: 10px; vertical-align: top; }
        .content { margin: 5px 0px; clear: both; }
        .content th { padding: 5px; font-size: 11px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderBottom { border-bottom: 1px solid #000; }
		.borderAll { border: 0px; border-top: 1px solid #000; border-bottom: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; border: 1px solid #000; padding: 10px; }
        .container .list { padding-left: 30px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
        /* p { font-size: 12px; } */
    </style>
    <title>Realisasi Anggaran</title>
</head>
<body>
    <div class="container">
        <div class="col-print-3 text-center">
            <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div>

        <div class="col-print-7">
            <p class="text-center font-weight-bold">
                DINAS KESEHATAN KOTA MALANG <br/>
                LAPORAN OPERASIONAL <br/>
                {{ $unitKerja->nama_unit }} <br/>
                <small>Untuk Tahun yang Berakhir Per 31 Desember {{ env('TAHUN_ANGGARAN', 2020) }}</small>
            </p>
        </div>

        <div class="clearfix"></div>

        <p class="text-right font-weight-bold">
            <small>(Dalam Rupiah)</small>
        </p>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderAll borderBottom text-center" width="30%">Uraian</th>
                <th class="borderAll borderBottom text-right" width="20%">{{ env('TAHUN_ANGGARAN', 2020) }}</th>
                <th class="borderAll borderBottom text-right" width="20%">{{ env('TAHUN_ANGGARAN', 2020)-1 }}</th>
                <th class="borderAll borderBottom text-center" width="20%"><i>Kenaikan / <br/> Penurunan</i></th>
                <th class="borderAll borderBottom text-center" width="5%"></th>
            </tr>

            {{-- 1 --}}

            <tr>
                <td class="borderNone text-left font-weight-bold"><u>KEGIATAN OPERASIONAL</u></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
            </tr>
            
            <tr>
                <td class="borderNone text-left font-weight-bold"><u>PENDAPATAN</u></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan jasa layanan dari masyarakat</td>
                <td class="borderNone text-right">{{ format_report($jasaLayananNow) }}</td>
                <td class="borderNone text-right">{{ format_report($jasaLayananPrevious) }}</td>
                <td class="borderNone text-right">{{ format_report(abs($jasaLayananPrevious-$jasaLayananNow)) }}</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan jasa layanan dari entitas akutansi/entitas pelaporan</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan hasil kerja sama</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan hibah</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan usaha lainnya</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan APBN/APBD</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderAll text-center font-weight-bold">Jumlah Pendapatan Asli Daerah</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jasaLayananNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jasaLayananPrevious) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($jasaLayananPrevious-$jasaLayananNow)) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>
            
            {{-- 1 --}}

            {{-- 2 --}}

            <tr>
                @for ($i = 0; $i < 5; $i++)
                    <td class="borderNone">&nbsp;</td>
                @endfor
            </tr>
            
            <tr>
                <td class="borderNone text-left font-weight-bold"><u>BEBAN</u></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Pegawai</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Persediaan</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Barang Jasa</td>
                <td class="borderNone text-right">{{ format_report($bebanBarangJasaNow) }}</td>
                <td class="borderNone text-right">{{ format_report($bebanBarangJasaPrevious) }}</td>
                <td class="borderNone text-right">{{ format_report(abs($bebanBarangJasaPrevious-$bebanBarangJasaNow)) }}</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Pemeliharaan</td>
                <td class="borderNone text-right">{{ format_report($bebanPemeliharaanNow) }}</td>
                <td class="borderNone text-right">{{ format_report($bebanPemeliharaanPrevious) }}</td>
                <td class="borderNone text-right">{{ format_report(abs($bebanPemeliharaanNow-$bebanPemeliharaanPrevious)) }}</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Langganan Daya dan Jasa</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>
            
            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Perjalanan Dinas</td>
                <td class="borderNone text-right">{{ format_report($bebanPerjalananDinasNow) }}</td>
                <td class="borderNone text-right">{{ format_report($bebanPerjalananDinasPrevious) }}</td>
                <td class="borderNone text-right">{{ format_report(abs($bebanPerjalananDinasNow-$bebanPerjalananDinasPrevious)) }}</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Penyusutan Aset</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Amortisasi Aset</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            @php
                $jumlahBebanNow = $bebanPerjalananDinasNow+$bebanPemeliharaanNow+$bebanBarangJasaNow;
                $jumlahBebanPrevious = $bebanPerjalananDinasPrevious+$bebanPemeliharaanPrevious+$bebanBarangJasaPrevious
            @endphp
            <tr>
                <td class="borderAll text-center font-weight-bold">JUMLAH BEBAN</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jumlahBebanNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jumlahBebanPrevious) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs($jumlahBebanNow-$jumlahBebanPrevious)) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>

            <tr>
                @for ($i = 0; $i < 5; $i++)
                    <td class="borderNone">&nbsp;</td>
                @endfor
            </tr>

            <tr>
                <td class="borderNone text-center font-weight-bold"><u>SURPLUS/DEFISIT DARI OPERASI</u></td>
                <td class="borderNone text-right font-weight-bold">{{ format_report($jasaLayananNow-$jumlahBebanNow) }}</td>
                <td class="borderNone text-right font-weight-bold">{{ format_report($jasaLayananPrevious-$jumlahBebanPrevious) }}</td>
                <td class="borderNone text-right font-weight-bold">{{ format_report(abs(($jasaLayananNow-$jumlahBebanNow)-($jasaLayananPrevious-$jumlahBebanPrevious))) }}</td>
                <td class="borderNone text-right font-weight-bold"></td>
            </tr>

            <tr>
                @for ($i = 0; $i < 5; $i++)
                    <td class="borderNone">&nbsp;</td>
                @endfor
            </tr>
            
            {{-- 2 --}}

            {{-- 3 --}}
            
            <tr>
                <td class="borderNone text-left font-weight-bold"><u>KEGIATAN NON OPERASIONAL</u></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Surplus/Defisit Penjuatan Aset Non Lancar</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">(Kerugian) Penurunan Nilai Aset</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Surplus/Defisit dari Kegiatan Non Operasional Lainnya</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left font-weight-bold" style="padding-left:30px;">JUMLAH SURPLUS/DEFISIT DARI KEGIATAN NON OPERASIONAL</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold"></td>
            </tr>

            <tr>
                <td class="borderNone text-center font-weight-bold">SURPLUS/DEFISIT SEBELUM POS LUAR BIASA</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold"></td>
            </tr>
            
            {{-- 3 --}}

            <tr>
                @for ($i = 0; $i < 5; $i++)
                    <td class="borderNone">&nbsp;</td>
                @endfor
            </tr>

            {{-- 4 --}}
            
            <tr>
                <td class="borderNone text-left font-weight-bold"><u>POS LUAR BIASA</u></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
                <td class="borderNone text-center"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Pendapatan Luar Biasa</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-left" style="padding-left: 30px;">Beban Luar Biasa</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right">0,00</td>
                <td class="borderNone text-right"></td>
            </tr>

            <tr>
                <td class="borderNone text-center font-weight-bold">JUMLAH POS LUAR BIASA</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold">0,00</td>
                <td class="borderNone text-right font-weight-bold"></td>
            </tr>

            <tr>
                <td class="borderAll text-center font-weight-bold">SURPLUS/DEFISIT - LO</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jasaLayananNow-$jumlahBebanNow) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report($jasaLayananPrevious-$jumlahBebanPrevious) }}</td>
                <td class="borderAll text-right font-weight-bold">{{ format_report(abs(($jasaLayananNow-$jumlahBebanNow)-($jasaLayananPrevious-$jumlahBebanPrevious))) }}</td>
                <td class="borderAll text-right font-weight-bold"></td>
            </tr>
            
            {{-- 4 --}}
        </table>

    </div>

    <div class="footer">
        <div class="col-print-8 text-center"></div>

        <div class="col-print-4 text-center">
            KOTA MALANG, {{ report_date($request->tanggal_pelaporan) }}<br/>
            Pemimpin BLUD <br/>

            <br/><br/><br/>

            <u><b>{{ $kepalaSkpd->nama_pejabat }}</b></u> <br/>
            NIP. {{ $kepalaSkpd->nip }}
        </div>
    </div>
</body>
</html>