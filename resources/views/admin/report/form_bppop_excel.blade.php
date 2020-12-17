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
        .content { border: 1px solid black; margin-bottom: 15px; }
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
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>Buku Pembantu Per Rincian Objek Penerimaan</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            Dinas Kesehatan Kota Malang <br/>
            BUKU PEMBANTU <br/>
            PER RINCIAN OBJEK PENERIMAAN <br/>
        </p>
        
        <div class="col-print-2">
            SPKD
        </div>

        <div class="col-print-1 text-right" style="padding-right: 5px;">:</div>

        <div class="col-print-9 text-left">
            Puskemas Janti    
        </div>

        <div class="clearfix"></div>

        <div class="col-print-2">
            Kode Rekening
        </div>

        <div class="col-print-1 text-right" style="padding-right: 5px;">:</div>

        <div class="col-print-9 text-left">
            
        </div>

        <div class="clearfix"></div>

        <div class="col-print-2">
            Jumlah Anggaran
        </div>

        <div class="col-print-1 text-right" style="padding-right: 5px;">:</div>

        <div class="col-print-9 text-left">
            Rp.
        </div>

        <div class="clearfix"></div>

        <div class="col-print-2">
            Tahun Anggaran
        </div>

        <div class="col-print-1 text-right" style="padding-right: 5px;">:</div>

        <div class="col-print-9 text-left">
            {{ env('TAHUN_ANGGARAN', 2020) }}
        </div>

        <div class="clearfix"></div>

        <table class="content">
            <tr>
                <th class="borderLeft text-center" style="padding: 8px;">No Urut</th>
                <th class="borderLeft text-center" style="padding: 8px;">
                    No BKU <br/> PENERIMAAN
                </th>
                <th class="borderLeft text-center" style="padding: 8px;">Tanggal Setor</th>
                <th class="borderLeft text-center" style="padding: 8px;">
                    Nomor STS & Bukti <br/> Penerimaan Lainnya
                </th>
                <th class="borderLeft text-center" style="padding: 8px;">
                    Jumlah <br/> (Rp) 
                </th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
            </tr>

            @php
                $totalPenerimaan = 0;
            @endphp
            @foreach ($bkuRincian as $key => $item)
                <tr>
                    <td class="text-center borderLeft">{{ $key+1 }}</td>
                    <td class="text-center borderLeft">{{ $item->bku->nomorbku }}</td>
                    <td class="text-left borderLeft">{{ report_date($item->bku->tanggal) }}</td>
                    <td class="text-left borderLeft">{{ $item->sts->nomorsts }}</td>
                    <td class="text-right borderLeft">{{ format_report($item->penerimaan) }}</td>
                </tr>
                @php
                    $totalPenerimaan += $item->penerimaan;
                @endphp
            @endforeach

        </table>
        
        <div class="col-print-6 text-left font-weight-bold">
            Jumlah bulan ini <br/>
            Jumlah s.d Bulan Lalu <br/>
            Jumlah s.d Bulan Ini <br/>
        </div>

        <div class="col-print-6 text-right font-weight-bold">
            {{ $totalPenerimaan }} <br/>
            00,00 <br/>
            {{ $totalPenerimaan }} <br/>
        </div>

        <div class="footer">
            <div class="col-print-6 text-center">
                <br/>
                Mengetahui, <br/>
                <strong>Pengguna Anggaran/Kuasa Pengguna Anggaran</strong> <br/>

                <br/><br/><br/>

                <u></u> <br/>
                NIP.
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, 22 Januari 2020 <br/><br/>
                <strong>Bendahara Penerimaan</strong> <br/>

                <br/><br/><br/>

                <u></u> <br/>
                NIP. 
            </div>
        </div>
    </div>
</body>
</html>