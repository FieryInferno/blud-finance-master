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
		.col-print-10{width:83%; float:left;}
		.col-print-11{width:92%; float:left;}
		.col-print-12{width:100%; float:left;}
		.clearfix{clear: both}
		table { width: 100%; }
		.content table { border-collapse: collapse; width: 100%; }
        .content table, td, th { border: 1px solid black; }
        th { padding: 8px; font-size: 10px; }
		td { padding: 5px; margin-left: 7px; font-size:10px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
        .borderTop { border: 0; border-top: 1px solid #000; }
		.borderNone { border: 0; }
        .header { border-bottom: 1px solid #000; }
    </style>
</head>
<body>
    <div class="col-print-12" style="font-size: 14px;">
        <div class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</div>
        <div class="text-center font-weight-bold">TAHUN ANGGARAN {{ env('TAHUN_ANGGARAN', 2020) }}</div>
        <div class="text-center font-weight-bold">BUKU KAS</div>
        <div class="text-center font-weight-bold">PENERIMAAN DAN PENGELUARAN</div>
        <div class="text-center font-weight-bold">{{ $bku->unitKerja->nama_unit }}</div>
        <p class="text-center">Tanggal: {{ report_date($bku->tanggal) }}</p>
    </div>

    <div class="clearfix"></div>

    <div class="col-print-12 content" style="font-size: 12px;"> 
        TAHUN ANGGARAN : {{ env('TAHUN_ANGGARAN', 2020) }} <br/>
        HALAMAN : 1 <br/>

        <br>

        <table>
            <tbody>
                <tr>
                    <th class="text-center" style="width: 10%">NO KAS</th>
                    <th class="text-center" style="width: 56%">URAIAN</th>
                    <th class="text-center" style="width: 16%">PENERIMAAN</th>
                    <th class="text-center" style="width: 16">PENGELUARAN</th>
                </tr>

                <tr>
                    <td class="borderLeft"></td>
                    <td class="borderLeft font-weight-bold text-center">Jumlah sampai dengan tanggal {{ report_date($bku->tanggal) }}</td>
                    <td class="borderLeft"></td>
                    <td class="borderLeft"></td>
                </tr>

                @foreach ($bku->bkuRincian as $item)
                    <tr>
                        <td class="borderLeft text-center">{{ $bku->nomorfix }}</td>
                        @if ($item->sts)
                            <td class="borderLeft">{{ $item->tipe }} No {{ $item->no_aktivitas }} {{ $item->tipe }} {{ $item->sts->keterangan }} {{ $item->sts->unitKerja->nama_unit }} {{ format_idr($item->penerimaan) }}</td>
                        @else 
                            <td class="borderLeft"></td>
                        @endif
                        <td class="borderLeft text-right">{{ format_idr($item->penerimaan) }}</td>
                        <td class="borderLeft text-right">{{ format_idr($item->pengeluaran) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="2" class="font-weight-bold text-center">Jumlah tanggal {{ report_date(date('Y-m-d')) }}</td>
                    <td class="font-weight-bold text-right">{{ format_idr($item->penerimaan) }}</td>
                    <td class="font-weight-bold text-right">0,00</td>
                </tr>

                <tr>
                    <td colspan="2" class="font-weight-bold text-center">Jumlah sampai dengan tanggal {{ report_date($bku->yesterday) }}</td>
                    <td class="font-weight-bold text-right">0,00</td>
                    <td class="font-weight-bold text-right">0,00</td>
                </tr>

                <tr>
                    <td colspan="2" class="font-weight-bold text-center">Jumlah sampai dengan tanggal {{ report_date(date('Y-m-d')) }}</td>
                    <td class="font-weight-bold text-right">{{ format_idr($item->penerimaan) }}</td>
                    <td class="font-weight-bold text-right">0,00</td>
                </tr>

                <tr>
                    <td colspan="2" class="font-weight-bold text-center">Saldo hari ini tanggal {{ report_date(date('Y-m-d')) }}</td>
                    <td class="font-weight-bold text-right">{{ format_idr($item->penerimaan) }}</td>
                    <td class="font-weight-bold text-right">0,00</td>
                </tr>

                <tr>
                    <td colspan="4" class="font-weight-bold text-left">Sisa dengan huruf: {{  strtoupper(terbilang($item->penerimaan)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>