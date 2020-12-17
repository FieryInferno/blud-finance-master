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
        span { padding-left: 30px; }
        .content p { font-size: 13px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderNone { border: 0; }
        /* .header { border-bottom: 1px solid #000; } */
    </style>
</head>
<body>
    <div class="header">
        <div class="col-print-3">
            <img style="width:70px; margin-top: 5px;" src="{{ public_path('img/logo.png') }}" alt="">
        </div>

        <div class="col-print-7">
            <p class="text-center font-weight-bold">
                PEMERINTAH DAERAH KOTA MALANG <br/>
                {{ strtoupper($sp3b->unitKerja->nama_unit) }} <br/>
                SURAT PERNYATAAN TANGGUNG JAWAB (SPTJ)
            </p>
        </div>
        
        <div class="clearfix"></div>
    </div>

    <div class="content">
        <div class="col-print-12">
            <p>
                <span>Sehubungan</span> dengan pengeluaran biaya {{ strtoupper($sp3b->unitKerja->nama_unit) }} Triwulan {{ $sp3b->triwulan }} Tahun {{ env('TAHUN_ANGGARAN', 2020) }} sebesar {{ format_idr($totalPengeluaran) }} ({{ strtoupper(terbilang($totalPengeluaran)) }}) yang berasal dari pendapatan : Jasa Layanan, Hibah, Hasil Kerjasama, dan Pendapatan Lain-lain yang Sah adalah tanggung jawab kami.
            </p>
            
            <p>
                <span>Pengeluaran</span> biaya tersebut diatas telah dilaksanakan dan dikelola berdasarkan sistem pengendalian intern yang memadai dalam kerangka pelaksanaan DPA, dan dibukukan sesuai dengan Standar Akuntansi yang berlaku pada BLUD dan bukti-bukti pengeluaran ada pada kami.
            </p>

            <p>
                <span>Demikian</span> surat Pernyataan ini kami buat untuk mendapatkan pengesahan pengeluaran Biaya BLUD {{ strtoupper($sp3b->unitKerja->nama_unit) }}.
            </p>
        </div>
        
        <div class="clearfix"></div>

        <br><br><br><br>

        <div class="col-print-6"></div>
        <div class="col-print-6 text-center" style="font-size: 12px;">
            KOTA MALANG, {{ report_date($sp3b->tanggal) }} <br/>
            <div class="font-weight-bold">
                Pemimpin BLUD
            </div>
            <br><br><br><br>
            {{ $pejabat->nama_pejabat }} <br/>
            NIP. {{ $pejabat->nip }}
        </div>
    </div>
</body>
</html>