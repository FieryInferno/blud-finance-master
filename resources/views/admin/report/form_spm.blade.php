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
		.borderRight { border-right: 1px solid #000; }
		.borderBottom { border: 0; border-bottom: 1px solid #000; padding: 3px; }
		.borderAll { border: 1px solid #000 !important; }
		.borderNone { border: 0; }
		.paddingNone { padding: 0 !important; }
        .fontDefault { font-size: 13px; }
        table { border-collapse: collapse; border-spacing: 0; width: 100%; }
        th { padding: 7px; text-align: center; }
        td { padding: 0; font-size: 11px; vertical-align: top; text-align: left; }
        .rekening table { border-collapse: collapse; border-spacing: 0; width: 100%; }
        .rightside table { border-collapse: collapse; border-spacing: 0; width: 100%; }
    </style>
    <title>Formulir SPP</title>
</head>
<body>
    <div class="container">
        <div class="text-center font-weight-bold">
            <span class="fontDefault">DINAS KESEHATAN KOTA MALANG</span> <br/>
            SURAT PERINTAH MEMBAYAR (SPM-BLUD) <br/>
            TAHUN ANGGARAN {{ env('TAHUN_ANGGARAN', 2020) }}
        </div>

        <div class="text-right fontDefault">
            Format: LS <br/>
            Nomor SPM :  {{ $spm->nomorspm }}
        </div>

        <table border="1">
            <tr>
                <td colspan="2" class="text-center">(diisi oleh PPK-BLUD)</td>
            </tr>

            <tr>
                <td width="50%">
                    PEJABAT PENATAUSAHAAN KEUANGAN BLUD {{ $spm->unitKerja->nama_unit }} <br/> 
                    Supaya menerbitkan SP2D kepada :
                </td>
                <td width="50%">Potongan-potongan:</td>
            </tr>

            <tr>
                <td width="50%">
                    <table>
                        <tr>
                            <td class="borderBottom">
                                BLUD: {{ $spm->unitKerja->nama_unit }} <br/>
                                Bendahara Pengeluaran Pembantu /Pihak Ketiga : {{ $spm->bendaharaPengeluaran->nama_pejabat }} / {{ $spm->pihakKetiga->nama_perusahaan }} <br/>
                                Nomor Rekening Bank: {{ $spm->pihakKetiga->no_rekening }} <br/>
                                NPWP :  {{ $spm->pihakKetiga->npwp }} <br/>
                                @foreach ($spm->referensiSpd as $item)
                                    Dasar Pembayaran/No. dan Tanggal SPD : {{ $item->spd->nomorspd }} dan {{ report_date($item->spd->tanggal) }}
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <td class="borderBottom">
                                Untuk Keperluan : {{ $spm->keterangan }}
                            </td>
                        </tr>

                        <tr>
                            <td class="borderBottom">
                                Pembebanan pada Kode Rekening : <br/>
                                <!-- List Kode Rekening -->
                                <table class="rekening">
                                    @foreach ($spm->bast->rincianPengadaan as $item)
                                        <tr>
                                            <td width="20%" class="text-left">{{ $spm->bast->kegiatan->kode_bidang }}.{{ $spm->bast->kegiatan->kode_program }}.{{ $spm->bast->kegiatan->kode }}</td>
                                            <td width="5%" class="text-center">:</td>
                                            <td width="30%" class="text-left">{{ $item->akun->nama_akun }}</td>
                                            <td width="30%" class="text-left">{{ format_idr($item->unit * $item->harga) }}</td>
                                        </tr>
                                    @endforeach

                                    @for($i = 1; $i <= 20; $i++) 
                                    <tr>
                                        <td width="20%" class="text-left">&nbsp;</td>
                                        <td width="5%" class="text-center"></td>
                                        <td width="30%" class="text-left"></td>
                                        <td width="30%" class="text-left"></td>
                                    </tr>
                                    @endfor
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td class="borderBottom">
                                Jumlah SPP yang diminta: <br/>
                                {{ format_idr($spm->nominal_sumber_dana) }} <i>({{ strtolower(terbilang($spm->nominal_sumber_dana)) }})</i> <br/>
                                Nomor dan Tanggal SPP : {{ $spm->nomorspp }} dan {{ report_date($spm->tanggal) }}
                            </td>
                        </tr>

                        <tr>
                            <td style="padding: 3px;">
                                *) Coret yang tidak perlu <br/>
                                **) Pilih yang sesuai
                            </td>
                        </tr>
                    </table> 
                </td>
                <td width="50%">
                    <table class="rightside">
                        <tr>
                            <th width="5%" class="borderAll">No.</th>
                            <th width="40%" class="borderAll">Uraian <br/> (Nomor Rekening)</th>
                            <th width="20%" class="borderAll">Jumlah</th>
                            {{-- <th width="30%" class="borderAll">Keterangan</th> --}}
                            <th width="30%" class="borderAll">Billing Pajak</th>
                        </tr>

                        @foreach ($spm->referensiPajak as $key => $item)
                            <tr>
                                <td class="text-center borderLeft">{{ $key+1 }}.</td>
                                <td class="text-left borderLeft">{{ $item->pajak->nama_pajak }}</td>
                                <td class="text-right borderLeft">{{ format_idr($item->nominal) }}</td>
                                {{-- <td class="text-center borderLeft borderRight">{{ $item->is_information ? ' Pajak sebagai informasi' : '' }}</td> --}}
                                <td class="text-center borderLeft borderRight">
                                    @foreach ($item->noBilling as $row)
                                        {{ $row->no_billing }} <br/>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach

                        @for($i = 1; $i <= 5; $i++)
                        <tr>
                            <td class="text-center borderLeft">&nbsp;</td>
                            <td class="text-left borderLeft"></td>
                            <td class="text-left borderLeft"></td>
                            <td class="text-left borderLeft borderRight"></td>
                        </tr>
                        @endfor

                        <tr>
                            <td class="text-left borderAll"></td>
                            <td class="text-right borderAll">Jumlah Potongan</td>
                            <td class="text-right borderAll">{{ format_idr($totalPotongan) }}</td>
                            <td class="text-left borderAll"></td>
                        </tr>
                    </table>
                    
                    <div style="padding: 10px 3px;">Informasi: (tidak mengurangi jumlah pembayaran SPM)</div>

                    <table class="rightside">
                        <tr>
                            <th width="5%" class="borderAll">No.</th>
                            <th width="40%" class="borderAll">Uraian <br/> (Nomor Rekening)</th>
                            <th width="20%" class="borderAll">Jumlah</th>
                            <th width="30%" class="borderAll">Keterangan</th>
                        </tr>

                        @for($i = 1; $i <= 6; $i++)
                        <tr>
                            <td class="text-center borderLeft">&nbsp;</td>
                            <td class="text-left borderLeft"></td>
                            <td class="text-left borderLeft"></td>
                            <td class="text-left borderLeft borderRight"></td>
                        </tr>
                        @endfor

                        <tr>
                            <td class="text-left borderAll"></td>
                            <td class="text-right borderAll">Jumlah</td>
                            <td class="text-right borderAll">Rp0,00</td>
                            <td class="text-right borderAll"></td>
                        </tr>

                        <tr>
                            <td class="text-right borderAll" colspan="2">Jumlah SPM</td>
                            <td class="text-right borderAll"></td>
                            <td class="text-right borderAll">{{ format_idr($spm->nominal_sumber_dana-$totalPotongan) }}</td>
                        </tr>
                    </table>

                    <div style="padding: 10px 3px;">Uang sejumlah: {{ strtolower(terbilang($spm->nominal_sumber_dana-$totalPotongan)) }}</div>
                    <div style="padding: 10px 0;" class="text-center">
                        KOTA MALANG, {{ report_date($spm->tanggal) }} <br/>
                        Kuasa Pengguna Anggaran, <br/>

                        <br/><br/><br/>

                        <u>{{ $spm->sppPemimpinBlud->nama_pejabat }}</u> <br/>
                        {{ $spm->sppPemimpinBlud->nip }}
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="text-center" style="padding: 5px;"><i>SPM ini sah apabila telah ditandatangani dan distempel oleh Kepala BLUD</i></td>
            </tr>
        </table>
    </div>
</body>
</html>