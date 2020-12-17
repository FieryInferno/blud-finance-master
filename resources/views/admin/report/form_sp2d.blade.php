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
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 13px; }
		.contentdata table { border-collapse: collapse; width: 100%; padding-top: 0; padding-bottom: 15px; }
		.contentdata td { padding: 5px; border: 1px solid #000; margin-left: 7px; font-size: 12px; }
		.contentdata th { padding: 5px; border: 1px solid #000; margin-left: 7px; font-size: 14px; }
        .footer { margin-top: 25px; font-size: 12px; clear: both; }
    </style>
    <title>Formulir SP2D</title>
</head>
<body>
    <div class="container">
        <!-- <div class="col-print-6 font-weight-bold text-center" style="padding: 25px 0px;">
			DINAS KESEHATAN KOTA MALANG
		</div>
        <div class="col-print-6 font-weight-bold text-center">
			<p><strong>Nomor:</strong> 00001/SP2D-LS/BLUD-PKM.1.02.01.08/2019</p>
			SURAT PERINTAH PENCARIAN DANA (SP2D)
		</div> -->

		<div class="col-print-12 font-weight-bold text-center">
			DINAS KESEHATAN KOTA MALANG <br/>
			SURAT PERINTAH PENCARIAN DANA (SP2D) BLUD<br/>
			Nomor: {{ $sp2d->nomorfix }}
		</div>

		<div class="clearfix"></div>

		<hr>

		<div class="col-print-6">
			<table>
				<tr>
					<td style="width: 30%;">Nomor SPM</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;">{{ $sp2d->nomorspm }}</td>
				</tr>

				<tr>
					<td style="width: 30%;">Tanggal</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;">{{ report_date($sp2d->tanggal) }}</td>
				</tr>

				<tr>
					<td style="width: 30%;">BLUD</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;">{{ $sp2d->unitKerja->nama_unit }}</td>
				</tr>
			</table>
		</div>

		<div class="col-print-6">
			<table>
				<tr>
					<td style="width: 30%;">Dari</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;">PPK BLUD {{ $sp2d->unitKerja->nama_unit }}</td>
				</tr>

				<tr>
					<td style="width: 30%;">Tahun</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;">{{ env('TAHUN_ANGGARAN', 2020) }}</td>
				</tr>
			</table>
		</div>

		<div class="clearfix"></div>

		<hr>

		<div class="col-print-12">
			Bank: {{ $sp2d->bast->pihakKetiga->nama_bank }} <br/>
			Hendaklah mencairkan / memindah bukukan dari buku Rekening Nomor <br/>
			Uang sebesar {{ format_idr($totalRincian - $totalPajak) }} <br/>
			Terbilang : <i>{{ strtolower(terbilang($totalRincian - $totalPajak)) }}</i>
		</div>

		<div class="clearfix"></div>

		<hr>

		<div class="col-print-12">
			<table>
				<tr>
					<td style="width: 14%;">Kepada</td>
					<td style="width: 1%;">:</td>
					<td style="width: 60%;">{{ $sp2d->bast->pihakKetiga->nama_perusahaan }}</td>
				</tr>

				<tr>
					<td style="width: 14%;">NPWP</td>
					<td style="width: 1%;">:</td>
					<td style="width: 60%;">{{ $sp2d->bast->pihakKetiga->npwp }}</td>
				</tr>

				<tr>
					<td style="width: 14%;">No. Rekening Bank</td>
					<td style="width: 1%;">:</td>
					<td style="width: 60%;">{{ $sp2d->bast->pihakKetiga->no_rekening }}</td>
				</tr>
				
				<tr>
					<td style="width: 14%;">Bank/Pos</td>
					<td style="width: 1%;">:</td>
					<td style="width: 60%;">{{ $sp2d->bast->pihakKetiga->nama_bank }}</td>
				</tr>

				<tr>
					<td style="width: 14%;">Keperluan Untuk</td>
					<td style="width: 1%;">:</td>
					<td style="width: 60%;">{{ $sp2d->keterangan }}</td>
				</tr>
			</table>
		</div>

		<div class="clearfix"></div>

		<div class="col-print-12 contentdata">
			<table>
				<tr>
					<th class="text-center">NO</th>
					<th class="text-center">KODE REKENING</th>
					<th class="text-center">URAIAN</th>
					<th class="text-center">JUMLAH (Rp)</th>
				</tr>
				@foreach ($sp2d->bast->rincianPengadaan as $key => $item)
					<tr>
						<td class="text-center">{{ $key+1 }}</td>
						<td class="text-left">{{ $item->kode_akun }}</td>
						<td class="text-left">{{ $item->akun->nama_akun }}</td>
						<td class="text-right">{{ format_report($item->unit * $item->harga) }}</td>
					</tr>
				@endforeach
				<tr>
					<td class="text-right font-weight-bold" colspan="3">Jumlah</td>
					<td class="text-right font-weight-bold">{{ format_report($totalRincian) }}</td>
				</tr>

				<tr>
					<td class="text-left" colspan="4">Potongan-potongan :</td>
				</tr>

				<tr>
					<th class="text-center">NO</th>
					<th class="text-center">Uraian (No. Rekening)</th>
					<th class="text-center">Jumlah (Rp)</th>
					<th class="text-center">Keterangan</th>
				</tr>
				@foreach ($sp2d->referensiPajak as $key => $item)
					<tr>
						<td class="text-center">{{ $key+1 }}</td>
						<td class="text-left">{{ $item->pajak->nama_pajak }}</td>
						<td class="text-right">{{  format_report($item->nominal) }}</td>
						<td class="text-left">{{ $item->is_information ? ' Pajak Sebagai Informasi' : '' }}</td>
					</tr>
				@endforeach
				<tr>
					<td class="text-right font-weight-bold" colspan="2">Jumlah</td>
				<td class="text-right font-weight-bold">{{ format_report($totalPajak) }}</td>
					<td class="text-left font-weight-bold"></td>
				</tr>

				<tr>
					<td class="text-left" colspan="4">Informasi: (tidak mengurangi jumlah pembayaran SP2D)</td>
				</tr>

				<tr>
					<th class="text-center">NO</th>
					<th class="text-center">Uraian</th>
					<th class="text-center">Jumlah (Rp)</th>
					<th class="text-center">Keterangan</th>
				</tr>

				<tr>
					<td class="text-center">&nbsp;</td>
					<td class="text-left">&nbsp;</td>
					<td class="text-right">&nbsp;</td>
					<td class="text-left">&nbsp;</td>
				</tr>

				<tr>
					<td class="text-right font-weight-bold" colspan="2">Jumlah</td>
					<td class="text-right font-weight-bold">0,00</td>
					<td class="text-left font-weight-bold"></td>
				</tr>

				<tr>
					<td class="text-left font-weight-bold" colspan="4">SP2D yang dibayarkan</td>
				</tr>

				<tr>
					<td class="text-left" colspan="2">Jumlah yang diminta (Rp)</td>
					<td class="text-right font-weight-bold" colspan="2">{{ format_report($totalRincian) }}</td>
				</tr>

				<tr>
					<td class="text-left" colspan="2">Jumlah potongan (Rp)</td>
					<td class="text-right font-weight-bold" colspan="2">{{ format_report($totalPajak) }}</td>
				</tr>

				<tr>
					<td class="text-leftd" colspan="2">Jumlah yang dibayarkan (Rp)</td>
					<td class="text-right font-weight-bold" colspan="2">{{ format_report($totalRincian - $totalPajak) }}</td>
				</tr>

				<tr>
					<td class="text-left" colspan="4">Uang sejumlah: <i>{{ strtolower(terbilang($totalRincian - $totalPajak)) }}</i></td>
				</tr>
			</table>
		</div>

		<div class="clearfix"></div>

		<div class="col-print-12" style="font-size: 12px;">
			Lembar 1 &nbsp; : PPK BLUD <br/>
			Lembar 2 &nbsp; : Bendahara Pengeluaran
		</div>

		<div class="footer">
            <div class="col-print-6"></div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($sp2d->tanggal) }}<br/>
                <strong>Pimpinan BLUD</strong> <br/>

                <br/><br/><br/>

                <u>{{ $sp2d->pejabatPemimpinBlud->nama_pejabat }}</u> <br/>
                NIP. {{ $sp2d->pejabatPemimpinBlud->nip }}
            </div>
        </div>
    </div>
</body>
</html>