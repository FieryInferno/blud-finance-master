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
		.content th { background: grey; }
		.content table { border-collapse: collapse; width: 100%; }
        th { padding: 8px; font-size: 14px; }
		td { padding: 5px; margin-left: 7px; font-size: 12px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderNone { border: 0; }
        tbody tr td { border: 1px solid #000 }
    </style>
</head>
<body>
    <div class="header">
        {{-- <div class="col-print-3">
            <img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div> --}}

        <div class="col-print-6">
            <p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
            <p class="text-center font-weight-bold" style="font-size: 18px;">BLUD PUSKESMAS DINOYO</p>
        </div>
        
        <div class="clearfix"></div>


        <div class="col-print-12">
            <p class="text-right font-weight-bold" style="font-size: 18px; margin-right: 50px;">KWITANSI</p>
        </div>

        <div class="clearfix"></div>
    </div>

    <div class="content">
        <div class="col-print-12">
            <table style="margin-top: 10px;">
                <tbody>
                    <tr>
                        <td style="width: 20%;">NO. KWITANSI</td>
                        <td style="width: 60%;">: {{ $tbp->nomorfix }}</td>
                    </tr>

                    <tr>
                        <td style="width: 20%;">Telah Terima dari</td>
                        <td style="width: 60%;">: Pasien</td>
                    </tr>

                    <tr>
                        <td style="width: 20%;">Untuk Pembayaran</td>
                        <td style="width: 60%;">: {{ $tbp->keterangan }}</td>
                    </tr>
                </tbody>
            </table>
            
            <table style="margin-top: 10px;">
                <tbody>
                    <tr>
                        <td style="width: 20%;">Sejumlah</td>
                        <td style="width: 60%;">: {{ format_idr($tbp->total_nominal) }}</td>
                    </tr>

                    <tr>
                        <td style="width: 20%;">Terbilang</td>
                        <td style="width: 60%;">: {{ strtoupper(terbilang($tbp->total_nominal)) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="clearfix"></div>

        <br><br><br><br>

        <div class="col-print-6"></div>
        <div class="col-print-6 text-center" style="font-size: 12px;">
            KOTA MALANG, <br/>
            <div class="font-weight-bold">
                Bendahara Penerimaan/Bendahara Penerimaan Pembantu
            </div>
            <br><br><br><br>
            <u>( {{ $tbp->bendaharaPenerima->nama_pejabat }} )</u><br>
            NIP. {{ $tbp->bendaharaPenerima->nip }}
        </div>
    </div>
</body>
</html>