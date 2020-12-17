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
        th { padding: 5px; font-size: 13px; }
        td { vertical-align: top; font-size: 13px; padding: 5px;}
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
        .borderTop { border-top: 1px solid #000; }
        .borderBottom { border-bottom: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; }
        .container .list { padding-left: 30px; }
        .box { border-top: 1px solid #000; padding: 7px 9px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>@if (isset($jenis)) Rincian SP2B @else  Rincian SP3B @endif</title>
</head>
<body>
    <div class="container" style="border: 1px solid #000;">
        <p class="text-center">
            <span class="font-weight-bold">
                @if ($jenis == 'sp2b') 
                    BADAN PENGELOLA KEUANGAN SELAKU PPKD
                @else 
                    DINAS KESEHATAN KOTA MALANG
                @endif
            </span><br/>
            <span class="font-weight-bold">SURAT PERMINTAAN PENGESAHAN PENDAPATAN DAN BELANJA (@if (isset($jenis)) SP2B @else  SP3B @endif) BLUD</span><br/>
            {{ isset($jenis) ? report_date($sp3b->date_verified) : report_date($sp3b->tanggal) }} Nomor {{ $sp3b->nomor }} <br/>
        </p>
    
        <div class="box">
            <span>Kepala/ Pengguna Anggaran Dinas Kesehatan Kota Malang memohon kepada :</span>
        </div>

        <div class="box">
            <span>Bendahara Umum Daerah selaku PPKD</span>
        </div>

        <div class="box">
            <span>Agar mengesahkan dan membukukan pendapatan dan belanja dana BLUD sejumlah :</span>
            <table style="margin-top: 8px;">
                <tr>
                    <td style="width: 5%" class="text-center">1.</td>
                    <td style="width: 30%">Saldo Awal</td>
                    <td style="width: 10%"> : Rp </td>
                    <td style="width: 15%" class="text-right">{{ format_report($totalSaldoAwal) }}</td>
                    <td></td>
                </tr>
                
                <tr>
                    <td style="width: 5%" class="text-center">2.</td>
                    <td style="width: 30%">Pendapatan</td>
                    <td style="width: 10%"> : Rp </td>
                    <td style="width: 15%" class="text-right">{{ format_report($totalPendapatan) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td style="width: 5%" class="text-center">3.</td>
                    <td style="width: 30%">Belanja</td>
                    <td style="width: 10%"> : Rp </td>
                    <td style="width: 15%" class="text-right">{{ format_report($totalPengeluaran) }}</td>
                    <td></td>
                </tr>
                
                <tr>
                    <td style="width: 5%" class="text-center">2.</td>
                    <td style="width: 30%">Saldo Akhir</td>
                    <td style="width: 10%"> : Rp </td>
                    <td style="width: 15%" class="text-right">{{ format_report($totalSaldoAwal+$totalPendapatan-$totalPengeluaran) }}</td>
                    <td></td>
                </tr>
            </table>
        </div>

        <div class="box">
            <span class="col-print-4 text-left">Untuk Bulan {{ bulan($bulan+2) }}</span>
            <span class="col-print-8 text-left">Tahun Anggaran {{ env('TAHUN_ANGGARAN', 2020) }}</span>
            <div class="clearfix"></div>
        </div>

        <div class="box">
            <table>
                <tr>
                    <th style="width: 25%" class="borderNone text-left">Dasar Pengesahan Perda APBD</th>
                    <th style="width: 25%" class="borderNone text-center">Urusan</th>
                    <th style="width: 25%" class="borderNone text-center">Organisasi</th>
                    <th style="width: 25%" class="borderNone text-center">Nama Unit</th>
                </tr>

                <tr>
                    <td class="borderNone text-left">Tanggal 26 Desember 2019</td>
                    <td class="borderNone text-center">1.02</td>
                    <td class="borderNone text-center">1.02.01</td>
                    <td class="borderNone text-center">{{ $sp3b->unitKerja->nama_unit }}</td>
                </tr>

                @for ($i = 0; $i < 3; $i++)
                <tr>
                    <td colspan="4"><br/></td>
                </tr>
                @endfor

                <tr>
                    <td class="borderNone" colspan="2">Program</td>
                    <td class="borderNone" colspan="2">Kegiatan</td>
                </tr>
            </table>
        </div>

        <table>
            <tr>
                <th width="50%" class="borderTop text-center" colspan="3">Pendapatan</th>
                <th width="50%" class="borderLeft borderTop text-center" colspan="3">Belanja</th>
            </tr>
            
            <tr>
                <th style="width: 30%" colspan="2" class="borderTop borderBottom text-center">Kode Rekening</th>
                <th style="width: 20%" class="borderLeft borderTop borderBottom text-center">Jumlah</th>
                <th style="width: 30%" colspan="2" class="borderLeft borderTop borderBottom text-center">Kode Rekening</th>
                <th style="width: 20%" class="borderLeft borderTop borderBottom text-center">Jumlah</th>
            </tr>

            @for ($i = 0; $i < $highestValue; $i++)
                <tr>
                    @php
                        $pendapatan = $rincianSp3b['pendapatan'][$i] ?? null;
                        $belanja = $rincianSp3b['belanja'][$i] ?? null;
                    @endphp
                    @if ($pendapatan)
                        <td class="text-center" width="5%">{{ $pendapatan['kode_akun_apbd'] }}</td>
                        <td class="text-left" width="40%">{{ $pendapatan['nama_akun_apbd']  }}</td>
                        <td class="borderLeft text-right">{{ format_report($pendapatan['nominal']) }}</td>
                    @else
                        <td class="text-center" width="5%"></td>
                        <td class="text-left" width="40%"></td>
                        <td class="borderLeft text-right"></td>
                    @endif

                    @if ($belanja)
                        <td class="borderLeft text-center" width="5%">{{ $belanja['kode_akun_apbd'] }}</td>
                        <td class="text-left" width="40%">{{ $belanja['nama_akun_apbd'] }}</td>
                        <td class="borderLeft text-right">{{ format_report($belanja['nominal']) }}</td>
                    @else
                        <td class="borderLeft text-center" width="5%"></td>
                        <td class="text-left" width="40%"></td>
                        <td class="borderLeft text-right"></td>
                    @endif
                </tr>
            @endfor
            
            <tr>
                <td class="borderTop text-center" colspan="2">Jumlah Pendapatan</td>
                <td class="borderTop borderLeft text-right">{{ format_report($totalPendapatan) }}</td>
                <td class="borderTop borderLeft text-center" colspan="2">Jumlah Belanja</td>
                <td class="borderTop borderLeft text-right">{{ format_report($totalPengeluaran) }}</td>
            </tr>
        </table>

        <div class="box">
            <div class="footer">
                <div class="col-print-6">
                </div>
    
                <div class="col-print-6 text-center">
                    KOTA MALANG, {{ isset($jenis) ? report_date($sp3b->date_verified) : report_date($sp3b->tanggal) }} <br/>
                    {{ isset($jenis) ? 'Kepala Badan Keuangan dan Asset Daerah' : 'Plt. KEPALA DINAS KESEHATAN' }}<br/>
                    KOTA MALANG <br/>
    
                    <br/><br/><br/>
    
                    <b><u>{{ isset($jenis) ? 'Drs. SUBKHAN, M.A.P' : 'SRI WINARNI, S.H., MM' }}</u></b> <br/>
                    Pembina Utama Muda <br/>
                    {{ isset($jenis) ? 'NIP. 19680408 198809 1 001' : 'NIP. 19650414 199210 2 001' }}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</body>
</html>