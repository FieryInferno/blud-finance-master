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
		.borderAll { border: 1px solid #000 !important; }
		.borderNone { border: 0; }
		.paddingNone { padding: 0 !important; }
        .fontDefault { font-size: 12px; }
        .container { font-size: 14px; }
        .checklist { margin-bottom: 30px; }
        .checklist p { font-size: 15px; }
        .checklist .kotak { margin-left: 10px; width: 50px; height: 20px; border: 1px solid; }
        .checklist table { border-collapse: collapse; width: 100%; }
        .checklist td { padding: 1px; margin: 1px;}
        .sppblud { border: 1px solid #000; }
        .sppblud .content { border-top: 1px solid #000; padding: 10px; }
        .sppblud .content .noborder td { font-size: 12px; }
        .sppblud table { border-collapse: collapse; width: 100%; }
        .sppblud th { padding: 7px; text-align: center; }
        .sppblud .table2 th { padding: 1px; font-size: 11px; }
        .sppblud .table2 td { padding: 3px; }
        .footer { margin: 25px 0; font-size: 14px; clear: both; }
        .footer p { padding-top: 25px; }
        .footer table { border-collapse: collapse; width: 100%; }
    </style>
    <title>Formulir SPP</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            PENELITIAN KELENGKAPAN DOKUMEN SPP
        </p>

        <p class="text-left">*) Coret yang tidak perlu.</p>

        <div class="checklist">
            <p class="font-weight-bold">1. SPP-UP</p>
            <table>
                @php
                $sppUp = [
                    'Surat Pengantar SPP-UP',
                    'Ringkasan SPP-UP',
                    'Rincian SPP-UP',
                    'Salinan SPD',
                    'Draft surat pernyataan untuk ditandatangani oleh pengguna anggaran/kuasa pengguna anggaran yang menyatakan bahwauang yang diminta tidak dipergunakan untuk keperluan selain uang persediaan saat pengajuan SP2D kepada kuasa BUD',
                    'Lampiran lainnya' 
                ];
                @endphp
                
                @foreach($sppUp as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>

            <p class="font-weight-bold">2. SPP-GU</p>
            <table>
                @php
                $sppGu = [
                    'Surat Pengantar SPP-GU',
                    'Ringkasan SPP-GU',
                    'Rincian SPP-GU',
                    'Salinan SPD',
                    'Surat pengesahan laporan pertanggungjawaban bendahara pengeluaran atas penggunaan dana SPP-UP/GU/TU sebelumnya',
                    'Draft surat pernyataan untuk ditandatangani oleh pengguna anggaran/kuasa pengguna anggaran yang menyatakan bahwa uang yang diminta tidak dipergunakan untuk keperluan selain ganti uang persediaan saat pengajuan SP2D kepada kuasa BUD',
                    'Lampiran lainnya'
                ];
                @endphp
                
                @foreach($sppGu as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>

            <p class="font-weight-bold">3. SPP-TU</p>
            <table>
                @php
                $sppTu = [
                    'Surat Pengantar SPP-TU',
                    'Ringkasan SPP-TU',
                    'Rincian SPP-TU',
                    'Salinan SPD',
                    'Surat Pengesahan SPJ',
                    'Draft surat pernyataan untuk ditandatangani oleh pengguna anggaran/kuasa pengguna anggaran yang menyatakan bahwa uang yang diminta tidak dipergunakan untuk keperluan selain tambahan uang persediaan saat pengajuan SP2D kepada kuasa BUD',
                    'Surat keterangan yang memuat penjelasan keperluan pengisian tambahan uang persediaan',
                    'Lampiran lainnya'
                ];
                @endphp
                
                @foreach($sppTu as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>

            <p class="font-weight-bold">4. SPP-LS - Khusus pembayaran gaji dan tunjangan</p>
            <table>
                @php
                $sppLs1 = [
                    'Surat Pengantar SPP-LS',
                    'Ringkasan SPP-LS',
                    'Rincian SPP-LS',
                    'Pembayaran gaji induk',
                    'Gaji susulan',
                    'Uang duka wafat/tewas yang dilengkapi dengan daftar gaji induk/gaji susulan/kekurangan gaji/uang duka wafat/tewas',
                    'SK CPNS',
                    'SK PNS',
                    'SK kenaikan pangkat',
                    'SK jabatan',
                    'Kenaikan gaji berkala',
                    'Surat pernyataan pelantikan',
                    'Surat pernyataan masih menduduki jabatan',
                    'Surat pernyataan melaksanakan tugas',
                    'Daftar keluarga (KP4)',
                    'Fotokopi surat nikah',
                    'Fotokopi akte kelahiran',
                    'SKPP',
                    'Daftar potongan sewa rumah dinas',
                    'Surat keterangan masih sekolah/kuliah',
                    'Surat pindah',
                    'Surat kematian',
                    'SSP PPH Pasal 21',
                    'Peraturan perundang-undangan mengenai penghasilan pimpinan dan anggota DPRD serta gaji dan tunjangan kepaladaerah/wakil kepala daerah'
                ];
                @endphp

                @foreach($sppLs1 as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>

            <p class="font-weight-bold">5. SPP-LS - Khusus pengadaan barang dan jasa</p>
            <table>
                @php
                $sppLs2 = [
                    'Surat Pengantar SPP-LS',
                    'Ringkasan SPP-LS',
                    'Rincian SPP-LS',
                    'Salinan SPD',
                    'Salinan Surat Rekomendasi dari SKPD teknis terkait',
                    'SSP disertai faktur pajak (PPN dan PPh) yang telah ditandatangani wajib pajak dan wajib pungut',
                    'Surat Perjanjian kerjasama/kontrak antara pengguna anggaran/kuasa pengguna anggaran dengan pihak ketiga serta mencantumkan nomor rekening bank pihak ketiga',
                    'Berita acara penyelesaian pekerjaan',
                    'Berita acara serah terima barang dan jasa',
                    'Berita acara pembayaran',
                    'Kwitansi bermaterai, nota/faktur yang ditandatangani oleh pihak ketiga dan PPTK serta disetujui oleh pengguna anggaran/kuasa pengguna anggaran',
                    'Surat jaminan bank atau yang dipersamakan yang dikeluarkan oleh bank atau lembaga keuangan non bank',
                    'Dokumen lain yang dipersyaratkan untuk kontrak-kontrak yang dananya sebagian atau seluruhnya bersumber dari penerusan pinjaman/hibah luar negeri',
                    'Berita acara pemeriksaan yang ditandatangani oleh pihak ketiga/rekanan serta unsur panitia pemeriksaan barang berikut lampiran daftar barang yang diperiksa',
                    'Surat angkutan atau konosemen apabila pengadaan barang dilaksanakan di luar wilayah kerja',
                    'Surat pemberitahuan potongan denda keterlambatan pekerjaan dari PPTK apabila pekerjaan mengalami keterlambatan',
                    'Foto/buku/dokumentasi tingkat kemajuan/penyelesaian pekerjaan',
                    'Potongan jamsostek (potongan sesuai dengan ketentuan yang berlaku/surat pemberitahuan jamsostek)',
                    'Khusus untuk pekerjaan konsultan yang perhitungan harganya menggunakan biaya personil (billing rate), berita acara prestasi kemajuan pekerjaan dilampiri dengan bukti kehadiran dari tenaga konsultan sesuai pentahapan waktu pekerjaan dan bukti penyewaan/pembelian alat penunjang serta bukti pengeluaran lainnya berdasarkan rincian dalam surat penawaran'
                ];
                @endphp

                @foreach($sppLs2 as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>
            <p class="font-weight-bold">6. SPP-LS - Khusus honor dan perjalanan dinas</p>
            <table>
                @php
                $sppLs3 = [
                    'Surat Pengantar SPP-LS',
                    'Ringkasan SPP-LS',
                    'Rincian SPP-LS',
                    'Salinan SPD',
                    'Surat Tugas / Surat Keputusan',
                    'Surat Perintah Perjalanan Dinas (SPPD) (PD)',
                    'Daftar Penerima Honor / Lembur / Perjalanan Dinas',
                    'Daftar Hadir',
                    'Kwitansi',
                    'Laporan Perjalanan Dinas',
                    'Rekapitulasi Pengeluaran At Cost (PD)'
                ];
                @endphp

                @foreach($sppLs3 as $row)
                <tr>
                    <td style="width: 10%;"><div class="kotak"></div></td>
                    <td style="width: 90%;">{{ $row }}</td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="col-print-6">
            <u class="font-weight-bold">PENELITI KELENGKAPAN DOKUMEN SPP</u> <br/>
            <table style="border-collapse: collapse; width: 100%;">
                <tr>
					<td style="width: 30%;">Tanggal</td>
					<td style="width: 10%;">:</td>
					<td style="width: 60%;"></td>
				</tr>
                <tr>
					<td style="width: 30%;">Nama</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">{{ $spp->bendaharaPengeluaran->nama_pejabat }}</td>
				</tr>
                <tr>
					<td style="width: 30%;">NIP</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">{{ $spp->bendaharaPengeluaran->nip }}</td>
				</tr>
            </table>

            <br/> <br/> <br/>

            <table style="border-collapse: collapse; width: 100%;">
                <tr>
					<td style="width: 30%;">Tanda Tangan</td>
					<td style="width: 70%;">: @for($i = 1; $i <= 25; $i++) . @endfor</td>
				</tr>
            </table>
        </div>

        <div class="col-print-6">
              <br/>
              <table style="border-collapse: collapse; width: 100%;">
                <tr>
					<td colspan="3">SPJ telah disahkan:</td>
				</tr>
                <tr>
					<td style="width: 30%;">Nama</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">{{ $pejabatPpk ? $pejabatPpk->nama_pejabat : '' }}</td>
				</tr>
                <tr>
					<td style="width: 30%;">NIP</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">{{ $pejabatPpk ? $pejabatPpk->nip : '' }}</td>
				</tr>
            </table>

            <br/> <br/> <br/>

            <table style="border-collapse: collapse; width: 100%;">
                <tr>
					<td style="width: 30%;">Tanda Tangan</td>
					<td style="width: 70%;">: @for($i = 1; $i <= 25; $i++) . @endfor</td>
				</tr>
            </table>
        </div>

        <div class="font-weight-bold" style="font-size: 10px; margin-top: 15px !important; clear: both;">
            <table>
                <tr>
					<td style="width: 30%;">Lembar asli</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Pengguna Anggaran/PPK-SKPD</td>
				</tr>
                <tr>
					<td style="width: 30%;">Salinan 1</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Bendahara Pengeluaran/PPTK</td>
				</tr>
                <tr>
					<td style="width: 30%;">Salinan 2</td>
					<td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Arsip Bendahara Pengeluaran/PPTK</td>
				</tr>
            </table>
        </div>

        <div class="page-break"></div>
        
        <!-- Layout ke-1 -->

        <p class="text-center font-weight-bold">
            {{ $spp->unitKerja->nama_unit }} <br/>
            SURAT PERMINTAAN PEMBAYARAN (SPP) BLUD <br/>
            Nomor :  {{ $spp->nomorspp }}
        </p>

        <div class="sppblud">
            <table>
                <tr>
                    <th style="width: 25%;">Uang Persediaan <br/> [1] SPP-UP</th>
                    <th style="width: 25%;">Ganti Uang Persediaan <br/> [2] SPP-GU</th>
                    <th style="width: 30%;">Tambahan Uang Persediaan <br/> [3] SPP-TU</th>
                    <th style="width: 25%;">Pembayaran Langsung <br/> [4] SPP-LS [X]</th>
                </tr>
            </table>
            <div class="content">
                <table class="noborder">
                    <!-- <th>
                        <th colspan="3"></th>
                        <th class="text-right">Kode</th>
                    </th> -->
                    <tr>
                        <!-- Left Side -->
                        <td width="18%">1. SPK</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">DINAS KESEHATAN</td>
                        <td width="5%" class="text-center">(1.02.01)</td>
                        <!-- Right Side -->
                        <td width="15%">7. Urusan Pemerintahan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">URUSAN WAJIB</td>
                        <td width="5%" class="text-center">(1)</td>
                    </tr>

                    <tr>
                        <!-- Left Side -->
                        <td width="18%">2. Unit Kerja</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">{{ $spp->unitKerja->nama_unit }}</td>
                        <td width="5%" class="text-center">(08)</td>
                        <!-- Right Side -->
                        <td width="15%">8. Nama Program</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">{{ $spp->bast->kegiatan->program->nama_program }}</td>
                        <td width="5%" class="text-center">({{ $spp->bast->kegiatan->kode_program }})</td>
                    </tr>

                    <tr>
                        <td colspan="6"></td>
                        <td width="20%">Pelayanan Kesehatan BLUD</td>
                        <td width="5%" class="text-center"></td>
                    </tr>

                    <tr>
                        <!-- Left Side -->
                        <td width="18%">3. Alamat</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">Malang</td>
                        <td width="5%" class="text-center">(........)</td>
                        <!-- Right Side -->
                        <td width="15%">9. Nama Kegiatan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">{{ $spp->bast->kegiatan->nama_kegiatan }}</td>
                        <td width="5%" class="text-center">({{ $spp->bast->kegiatan->kode_program }}.{{ $spp->bast->kegiatan->kode_kegiatan }})</td>
                    </tr>

                    <tr>
                        <td colspan="6"></td>
                        <td width="20%">Pelayanan BLUD</td>
                        <td width="5%" class="text-center"></td>
                    </tr>

                    <tr>
                        <td colspan="6"></td>
                        <td width="20%">{{ $spp->unitKerja->nama_unit }}</td>
                        <td width="5%" class="text-center"></td>
                    </tr>

                    {{-- <tr>
                        <!-- Left Side -->
                        <td width="18%">4. No DPA-SPKD/DPPA-</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">-</td>
                        <td width="5%" class="text-center">(........)</td>
                        <!-- Right Side -->
                        <td colspan="4"></td>
                    </tr> --}}
                    
                    {{-- <tr>
                        <!-- Left Side -->
                        <td width="18%">
                            &nbsp;&nbsp;&nbsp;
                            SPKD/DPAL-SKPD
                        </td>
                        <td colspan="7"></td>
                    </tr> --}}

                    {{-- <tr>
                        <!-- Left Side -->
                        <td width="18%">
                            &nbsp;&nbsp;&nbsp;
                            Tanggal DPA-SKPD/DP
                        </td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">01 Oktober 2018</td>
                        <td width="5%" class="text-center">(........)</td>
                        <!-- Right Side -->
                        <td colspan="4"></td>
                    </tr>
                     --}}
                    {{-- <tr>
                        <!-- Left Side -->
                        <td width="18%">
                            &nbsp;&nbsp;&nbsp;
                            PA-SKPD/DPAL-SKPD
                        </td>
                        <td colspan="7"></td>
                    </tr> --}}

                    <tr>
                        <!-- Left Side -->
                        <td width="18%">5. Tahun Anggaran</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">{{ env('TAHUN_ANGGARAN', 2020) }}</td>
                        <td width="5%" class="text-center">(........)</td>
                        <!-- Right Side -->
                        <td colspan="4"></td>
                    </tr>

                    <tr>
                        <!-- Left Side -->
                        <td width="18%">6. Bulan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="20%">{{ bulan(explode('-', $spp->tanggal)[1]) }}</td>
                        <td width="5%" class="text-center">(........)</td>
                        <!-- Right Side -->
                        <td colspan="4"></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="col-print-6"></div>
            <div class="col-print-6 text-left">
                Kepada Yth,<br/>
                Pengguna Anggaran/Kuasa Pengguna Anggaran <br/>
                {{ $spp->unitKerja->nama_unit }} <br/>
                
                <br/><br/>
                
                di - <br/>
                &nbsp;&nbsp; KOTA MALANG 
            </div>

            <div class="clearfix"></div>
            
            <p>
            @for($i = 1; $i <= 10; $i++) &nbsp; @endfor
            Dengan memperhatikan Peraturan Walikota Pemerintah Kota  KOTA MALANG Nomor 36 Tahun 2018 tentang Penjabaran APBD 2019, bersama ini kami mengajukan Surat Permintaan Pembayaran sebagai berikut :
            </p>

            <table>
                <tr>
                    <td style="width: 40%;">a. Jumlah pembayaran yang diminta</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ format_report($spp->nominal_sumber_dana) }}</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td style="width: 55%;"><i>({{ strtolower(terbilang($spp->nominal_sumber_dana)) }})</i></td>
                </tr>
                <tr>
                    <td style="width: 40%;">b. Untuk keperluan</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ $spp->keterangan }}</td>
                </tr>
                <tr>
                    <td style="width: 40%;">c. Nama bendahara pengeluaran/pihak ketiga</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ $spp->bendaharaPengeluaran->nama_pejabat }} / {{ $spp->pihakKetiga->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <td style="width: 40%;">d. Alamat</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ $spp->pihakKetiga->alamat }}</td>
                </tr>
                <tr>
                    <td style="width: 40%;">e. Nama Bank</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ $spp->pihakKetiga->nama_bank }}</td>
                </tr>
                <tr>
                    <td style="width: 40%;">f. No Rekening Bank</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 55%;">{{ $spp->pihakKetiga->no_rekening }}</td>
                </tr>
            </table>

            <div class="clearfix"></div>

            <div class="col-print-6 text-center">
                <br/>
                <strong>Mengetahui</strong><br/>
                <strong>Pejabat Pelaksana Teknis Kegiatan</strong> <br/>
                {{ $spp->unitKerja->nama_unit }}<br/>
                
                <br/><br/><br/>
                
                <u>{{ $spp->sppPptk->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->sppPptk->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($spp->tanggal) }} <br/><br/>
                <strong>Bendahara Pengeluaran Pembantu</strong> <br/>

                <br/><br/><br/>
                
                <u>{{ $spp->bendaharaPengeluaran->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->bendaharaPengeluaran->nip }}
            </div>
        </div>

        <div class="clearfix"></div>
        
        <div style="margin-top: 30px !important;">
            <div style="font-size: 11px; padding-left: 10px;">* Jika SPP LS Pengadaan barang dan jasa Pejabat Pelaksana Teknis Kegiatan ikut menandatangani.</div>
            <table class="font-weight-bold" style="font-size: 10px;">
                <tr>
                    <td style="width: 30%;">Lembar asli</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Pengguna Anggaran/PPK-SKPD</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 1</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Bendahara Pengeluaran/PPTK</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 2</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Arsip Bendahara Pengeluaran/PPTK</td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>
        
        <!-- Layout ke-2 -->

        <p class="text-center font-weight-bold">
            {{ $spp->unitKerja->nama_unit }} <br/>
            SURAT PERMINTAAN PEMBAYARAN (SPP) BLUD <br/>
            Nomor :  {{ $spp->nomorspp }}
        </p>

        <div class="sppblud">
            <table>
                <tr>
                    <th style="width: 25%;">Uang Persediaan <br/> [1] SPP-UP</th>
                    <th style="width: 25%;">Ganti Uang Persediaan <br/> [2] SPP-GU</th>
                    <th style="width: 30%;">Tambahan Uang Persediaan <br/> [3] SPP-TU</th>
                    <th style="width: 25%;">Pembayaran Langsung <br/> [4] SPP-LS [X]</th>
                </tr>
            </table>
            <div class="content">
                <table class="noborder">
                    <tr>
                        <td width="25%">1. Jenis Kegiatan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%">
                            a. Gaji dan Tunjangan
                            @for($i = 1; $i <= 10; $i++) &nbsp; @endfor
                            b. Barang dan Jasa
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"></td>
                        <td width="70%">
                            c. Pengembalian Pendapatan
                            @for($i = 1; $i <= 5; $i++) &nbsp; @endfor
                            d. Lainnya
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="25%" class="text-left">2. Nomor dan Nama Kegiatan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->bast->kegiatan->kode_kegiatan }} - {{ $spp->bast->kegiatan->nama_kegiatan }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">3. Alamat SPKD/Unit Kerja</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">Malang / {{ $spp->unitKerja->nama_unit }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">4. Nama Perusahaan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->pihakKetiga->nama_perusahaan }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">5. Bentuk Perusahaan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left"></td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">6. Alamat Perusahaan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->pihakKetiga->alamat }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">7. Nama Pimpinan Perusahaan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->pihakKetiga->nama }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">8. Nama dan No. Rekening Bank</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->pihakKetiga->nama_bank }} ({{ $spp->pihakKetiga->no_rekening }})</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">9. Nomor Kontrak</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->bast->no_kontrak }}</td>
                    </tr>

                    <tr>
                        <td width="25%" class="text-left">10. Untuk Pekerjaan/Keperluan</td>
                        <td width="1%" class="text-right">:</td>
                        <td width="70%" class="text-left">{{ $spp->keterangan }}</td>
                    </tr>

                    @php
                        $noSpd = 11;
                    @endphp
                    @foreach ($spp->referensiSpd as $item)
                        <tr>
                            <td width="25%" class="text-left">{{ $noSpd }}. Dasar Pengeluaran</td>
                            <td width="1%" class="text-right">:</td>
                            <td width="70%" class="text-left">- {{ $item->spd->nomorspd }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"></td>
                            <td width="70%" class="text-left">- Tanggal: {{ report_date($item->spd->tanggal) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"></td>
                            <td width="70%" class="text-left">- Sebesar:  {{ format_idr($item->spd->totalspd) }}</td>
                        </tr>

                        <tr>
                            <td colspan="2"></td>
                            <td width="70%" class="text-left">- Terbilang: <i>( {{ Ucfirst(terbilang($item->spd->totalspd) ) }})</i></td>
                        </tr>
                    @php
                        $noSpd++;
                    @endphp
                    @endforeach
                </table>

                <div class="clearfix"></div>

            </div>
            
            <table class="table2">
                <tr>
                    <th width="5%" class="borderAll text-center">No.</th>
                    <th width="30%" class="borderAll text-center">Uraian</th>
                    <th width="60%" colspan="3" class="borderAll text-center">Jumlah Mata Anggaran Bersangkutan</th>
                </tr>

                <!-- I -->

                <tr class="fontDefault">
                    <td class="borderLeft text-center">I</td>
                    <td class="borderLeft text-left">DPA-SKPD/DPKA-SKPD/DPAL-SKPD</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">Tanggal: -</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right">I Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">Nomor: -</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <!-- II -->

                <tr class="fontDefault">
                    <td class="borderLeft text-center">II</td>
                    <td class="borderLeft text-left">SPD</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                @php
                    $totalSpd = 0;
                @endphp
                @foreach ($spp->referensiSpd as $item)
                    <tr class="fontDefault">
                        <td class="borderLeft text-center"></td>
                        <td class="borderLeft text-left">Tanggal: {{ report_date($item->spd->tanggal) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right">II {{ format_idr($item->spd->totalspd) }}</td>
                        <td class="borderLeft text-right"></td>
                    </tr>

                    <tr class="fontDefault">
                        <td class="borderLeft text-center"></td>
                        <td class="borderLeft text-left">Nomor: {{ $item->spd->nomorspd }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                    </tr>
                    @php
                        $totalSpd += $item->spd->totalspd;
                    @endphp
                @endforeach

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right">I-II Rp0,00</td>
                </tr>

                <!-- III -->

                <tr class="fontDefault">
                    <td class="borderLeft text-center">III</td>
                    <td class="borderLeft text-left">SP2D</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan UP</td>
                    <td class="borderLeft text-right">Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan GU</td>
                    <td class="borderLeft text-right">Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan TU</td>
                    <td class="borderLeft text-right">Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan LS pembayaran gaji dan tunjangan</td>
                    <td class="borderLeft text-right">Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan pengadaan barang dan jasa</td>
                    <td class="borderLeft text-right">Rp0,00</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left">SPD peruntukan pembiayaan LS</td>
                    <td class="borderLeft text-right">{{ format_idr($spp->nominal_sumber_dana) }}</td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right"></td>
                </tr>

                <tr class="fontDefault">
                    <td class="borderLeft text-center"></td>
                    <td class="borderLeft text-left"></td>
                    <td class="borderLeft text-right"></td>
                    <td class="borderLeft text-right">III {{ format_idr($spp->nominal_sumber_dana) }}</td>
                    <td class="borderLeft text-right">II-III {{ format_idr($totalSpd-$spp->nominal_sumber_dana) }}</td>
                </tr>                

                <tr class="fontDefault">
                    <td class="borderAll text-center" colspan="5" style="padding: 5px;">
                        Pada SPP ini ditetapkan lampiran-lampiran yang diperlukan sebagaiman tertera pada daftar kelengkapan dokumen SPP-I
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="clearfix"></div>

            <div class="col-print-6 text-center">
                <br/>
                <strong>Mengetahui</strong><br/>
                <strong>Pejabat Pelaksana Teknis</strong> <br/>
                {{ $spp->unitKerja->nama_unit }} <br/>
                
                <br/><br/><br/>
                
                <u>{{ $spp->sppPptk->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->sppPptk->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($spp->tanggal) }} <br/><br/>
                <strong>Bendahara Pengeluaran Pembantu</strong> <br/>

                <br/><br/><br/>
                
                <u>{{ $spp->bendaharaPengeluaran->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->bendaharaPengeluaran->nip }}
            </div>
        </div>

        <div class="clearfix"></div>

        <div style="margin-top: 30px !important;">
            <table class="font-weight-bold" style="font-size: 10px;">
            <tr>
                    <td style="width: 30%;">Lembar asli</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Pengguna Anggaran/PPK-SKPD</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 1</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Kuasa BUD</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 2</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Bendahara Pengeluaran/PPTK</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 3</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Arsip Bendahara Pengeluaran/PPTK</td>
                </tr>
            </table>
        </div>

        <div class="page-break"></div>
        
        <!-- Layout ke-3 -->

        <p class="text-center font-weight-bold">
            {{ $spp->unitKerja->nama_unit }}<br/>
            SURAT PERMINTAAN PEMBAYARAN (SPP) BLUD <br/>
            Nomor :  {{ $spp->nomorspp }}
        </p>

        <div class="sppblud">
            <table>
                <tr>
                    <th style="width: 25%;">Uang Persediaan <br/> [1] SPP-UP</th>
                    <th style="width: 25%;">Ganti Uang Persediaan <br/> [2] SPP-GU</th>
                    <th style="width: 30%;">Tambahan Uang Persediaan <br/> [3] SPP-TU</th>
                    <th style="width: 25%;">Pembayaran Langsung <br/> [4] SPP-LS [X]</th>
                </tr>
            </table>
            <div style="border-top: 1px solid #000;">
                <h4 class="text-center">RINCIAN RENCANA PENGGUNAAN</h4>
                <h5 class="text-center">TAHUN ANGGARAN {{ env('TAHUN_ANGGARAN', 2020) }}</h5>
                
                <table>
                    <tr>
                        <th width="10%" class="borderAll text-center">No.</th>
                        <th width="30%" class="borderAll text-center">Kode Rekening</th>
                        <th width="35%" class="borderAll text-center">Uraian</th>
                        <th width="25%" class="borderAll text-center">Jumlah <br/> (Rp)</th>
                    </tr>

                    <tr>
                        <th class="borderAll paddingNone">1</th>
                        <th class="borderAll paddingNone">2</th>
                        <th class="borderAll paddingNone">3</th>
                        <th class="borderAll paddingNone">4</th>
                    </tr>

                    @php
                        $totalPengadaan = 0;
                    @endphp
                    @foreach ($spp->bast->rincianPengadaan as $key => $item)
                        <tr class="fontDefault">
                            <td class="borderLeft text-center">{{ $key+1 }}</td>
                            <td class="borderLeft text-left">{{ $item->akun->kode_akun }}</td>
                            <td class="borderLeft text-left">{{ $item->akun->nama_akun }}</td>
                            <td class="borderLeft text-right">{{ format_report($item->harga*$item->unit) }}</td>
                            @php
                                $totalPengadaan+=$item->harga*$item->unit;
                            @endphp
                        </tr>
                    @endforeach

                    @for($i = 1; $i <= 10; $i++)
                    <tr>
                        <td class="borderLeft">&nbsp;</td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                        <td class="borderLeft"></td>
                    </tr>
                    @endfor

                    <tr class="fontDefault">
                        <td class="borderAll text-right" colspan="3">Jumlah</td>
                        <td class="borderAll text-right">{{ format_report($totalPengadaan) }}</td>
                    </tr>

                    <tr class="fontDefault">
                        <td class="borderAll text-left" colspan="4" style="padding: 5px;">
                            Terbilang: <i>({{ strtolower(terbilang($totalPengadaan)) }})</i>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="clearfix"></div>

            <div class="col-print-6 text-center">
                <br/>
                <strong>Mengetahui</strong><br/>
                <strong>Pejabat Pelaksana Teknis</strong> <br/>
                {{ $spp->unitKerja->nama_unit }} <br/>
                
                <br/><br/><br/>
                
                <u>{{ $spp->sppPptk->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->sppPptk->nip }}
            </div>

            <div class="col-print-6 text-center">
                KOTA MALANG, {{ report_date($spp->tanggal) }} <br/><br/>
                <strong>Bendahara Pengeluaran Pembantu</strong> <br/>

                <br/><br/><br/>
                
                <u>{{ $spp->bendaharaPengeluaran->nama_pejabat }}</u> <br/>
                NIP. {{ $spp->bendaharaPengeluaran->nip }}
            </div>
        </div>

        <div class="clearfix"></div>

        <div style="margin-top: 30px !important;">
            <table class="font-weight-bold" style="font-size: 10px;">
                <tr>
                    <td style="width: 30%;">Lembar asli</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Pengguna Anggaran/PPK-SKPD</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 1</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Kuasa BUD</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 2</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Bendahara Pengeluaran/PPTK</td>
                </tr>
                <tr>
                    <td style="width: 30%;">Salinan 3</td>
                    <td style="width: 10%;">:</td>
                    <td style="width: 60%;">Untuk Arsip Bendahara Pengeluaran/PPTK</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>