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
		.content table, td, th { border: 1px solid black; }
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
        .header { border-bottom: 1px solid #000; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
            <p class="text-center font-weight-bold">SURAT TANDA SETORAN <br/> (STS)</p>
            <p class="text-center font-weight-bold">1.02.01.{{ $sts->kode_unit_kerja }} - {{ $sts->unitKerja->nama_unit }}</p>
        </div>
        
        <div class="col-print-7">
            <p style="font-size: 12px; margin-left: 10px;">
                STS No. <br/>
                {{ $sts->nomorfix }}
            </p>
        </div>
        <div class="col-print-5">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 39%;">Bank</td>
                        <td style="width: 1%;" class="text-right">:</td>
                        <td style="width: 60%;">{{ $sts->rekeningBendahara->nama_bank }}</td>
                    </tr>

                    <tr>
                        <td style="width: 39%;">No Rekening</td>
                        <td style="width: 1%;" class="text-right">:</td>
                        <td style="width: 60%;">{{ $sts->rekeningBendahara->rekening_bank }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="clearfix"></div>

        <div class="col-print-12">
            <table style="margin-top: 10px;">
                <tbody>
                    <tr>
                        <td style="width: 20%;">Harapan diterima uang sebesar</td>
                        <td style="width: 60%;">{{ format_idr($sts->total_nominal) }}</td>
                    </tr>

                    <tr>
                        <td style="width: 20%;">(dengan huruf)</td>
                        <td style="width: 60%; font-size: 10px;"><i>( {{ strtoupper(terbilang($sts->total_nominal)) }} )</i></td>
                    </tr>

                    <tr>
                        <td style="width: 20%;">Keterangan</td>
                        <td style="width: 60%;"> {{ $sts->keterangan }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="clearfix"></div>

        <!-- Rincian Penerimaan -->
        <div class="col-print-12 content" style="font-size: 12px; margin: 0px 10px;">
            Dengan rincian penerimaan sebagai berikut:
            <table style="margin: 5px 0px 10px;">
                <tbody>
                    <tr>
                        <th class="text-left" style="width: 5%">No</th>
                        <th class="text-center" style="width: 40%" colspan="12">Kode Rekening</th>
                        <th class="text-center" style="width: 30%">Kode Uraian Rincian Obyek</th>
                        <th class="text-center" style="width: 25%">Jumlah (Rp)</th>
                    </tr>

                    @foreach ($sts->rincianSts as $item)
                        <tr>
                            <td class="borderLeft">1</td>
                            <td class="borderLeft">1.02</td>
                            <td class="borderLeft">1.02.01</td>
                            <td class="borderLeft">00</td>
                            <td class="borderLeft">00</td>
                            <td class="borderLeft">{{ $item->akun->tipe }}</td>
                            <td class="borderLeft">{{ $item->akun->kelompok }}</td>
                            <td class="borderLeft">{{ $item->akun->jenis }}</td>
                            <td class="borderLeft">{{ $item->akun->objek }}</td>
                            <td class="borderLeft">{{ $item->akun->rincian }}</td>
                            <td class="borderLeft"></td>
                            <td class="borderLeft"></td>
                            <td class="borderLeft"></td>
                            <td class="borderLeft">{{ $item->akun->nama_akun }}</td>
                            <td class="borderLeft text-right">{{ format_report($item->nominal) }}</td>
                        </tr>
                    @endforeach

                    @for($i = 0; $i <= 10; $i++)
                    <tr>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft text-right"></td>
                    </tr>
                    @endfor

                    <tr>
                        <td colspan="14" class="text-right font-weight-bold">Jumlah</td>
                        <td class="text-right font-weight-bold">{{ format_idr($sts->total_nominal) }}</td>
                    </tr>
                </tbody>
            </table>
            
            Uang tersebut diterima pada tanggal {{ report_date($sts->tanggal) }}
        </div>

        <div class="clearfix"></div><br>

        <div class="col-print-6 text-center" style="font-size: 12px;">
            Mengetahui, <br/>
            <div class="font-weight-bold">Pengguna Anggaran/Kuasa Pengguna Anggaran</div>
            <br><br><br><br>
            <u>( {{ $sts->kepalaSkpd->nama_pejabat }} )</u><br>
            NIP. {{ $sts->kepalaSkpd->nip }}
        </div>

        <div class="col-print-6 text-center" style="font-size: 12px;">
            <br/>
            <div class="font-weight-bold">
                Bendahara Penerimaan/<br/>
                Bendahara Penerimaan Pembantu
            </div>
            <br><br><br><br>
            <u>( {{ $sts->bendaharaPenerima->nama_pejabat }} )</u><br>
            NIP. {{ $sts->bendaharaPenerima->nip }}
        </div>

        <div class="clearfix"></div><br>

        <i style="font-size: 12px; margin-left: 20px;">(Catatan: STS dilampiri Slip Setoran Bank)</i>

        <br><br>
    </div>
</body>
</html>