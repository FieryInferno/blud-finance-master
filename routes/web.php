<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('deploy', 'DeployController@deploy');
Route::get('deploy/testtt', 'DeployController@testDeploy');

Auth::routes();

Route::prefix('report')->group(function () {
    Route::get('sts', 'ReportController@sts');
    Route::get('tbp', 'ReportController@tbp');
    Route::get('spd', 'ReportController@spd');
    Route::get('bppop', 'ReportController@bppop');
    Route::get('bku_bendahara', 'ReportController@bku_bendahara');
    Route::get('register_sts', 'ReportController@register_sts');
    Route::get('spp', 'ReportController@spp');
    Route::get('sp2d', 'ReportController@sp2d');
    Route::get('spm', 'ReportController@spm');
    Route::get('spj_pendapatan_fungsional', 'ReportController@spj_pendapatan_fungsional');
    Route::get('spj_belanja_fungsional', 'ReportController@spj_belanja_fungsional');
    Route::get('buku_pembantu_pajak', 'ReportController@buku_pembantu_pajak');
    Route::get('buku_bppop', 'ReportController@buku_bppop');
    Route::get('buku_robbp', 'ReportController@buku_robbp');
    Route::get('sp3b', 'ReportController@sp3b');
    Route::get('laporan_sptj', 'ReportController@laporan_sptj');
    Route::get('robbp', 'ReportController@robbp');
    Route::get('register_spp_spm_sp2d', 'ReportController@register_spp_spm_sp2d');
    Route::get('realisasi_anggaran', 'ReportController@realisasi_anggaran');
    Route::get('penjabaran_apbd', 'ReportController@penjabaran_apbd');
    Route::get('laporan_operasional', 'ReportController@laporan_operasional');
    Route::get('neraca', 'ReportController@neraca');
    Route::get('laporan_perubahan_ekuitas', 'ReportController@laporan_perubahan_ekuitas');
    Route::get('laporan_perubahan_sal', 'ReportController@laporan_perubahan_sal');
    Route::get('laporan_arus_kas', 'ReportController@laporan_arus_kas');
    
    Route::get('excel/bku_bendahara', 'ReportController@bku_bendahara_excel');
    Route::get('excel/bppop', 'ReportController@bppop_excel');
    Route::get('excel/register_sts', 'ReportController@register_sts_excel');
});

Route::prefix('finance')->namespace('Admin')->middleware('auth')->group(function () {
    Route::get('/', 'AdminController@index')->name('admin.index');

    Route::prefix('report-bendahara-penerima')->group(function (){
        Route::get('register-sts', 'ReportBendaharaPenerimaController@registerStsView')->name('report.register_sts.view');
        Route::post('register-sts', 'ReportBendaharaPenerimaController@registerSts')->name('report.register_sts.store');
        Route::post('register-sts-pdf', 'ReportBendaharaPenerimaController@registerStsPdf')->name('report.register_sts_pdf.store');
        Route::post('register-tbp-pdf', 'ReportBendaharaPenerimaController@registerTbpPdf')->name('report.register_tbp_pdf.store');
        Route::get('bku-bendahara-penerimaan', 'ReportBendaharaPenerimaController@bkuBendaharaView')->name('report.bku_bendahara.view');
        Route::post('bku-bendahara-penerimaan', 'ReportBendaharaPenerimaController@bkuBendahara')->name('report.bku_bendahara.store');
        Route::post('spd-fungsional', 'ReportBendaharaPenerimaController@spjFungsional')->name('report.spj_fungsional.store');
        Route::post('buku-rincian-objek', 'ReportBendaharaPenerimaController@bukuRincian')->name('report.buku_rincian.store');
        Route::get('rincian-objek-penerimaan', 'ReportBendaharaPenerimaController@objekPenerimaanView')->name('report.objek_penerimaan.view');
        Route::post('rincian-objek-penerimaan', 'ReportBendaharaPenerimaController@objekPenerimaan')->name('report.objek_penerimaan.store');
    });

    Route::prefix('report-bendahara-pengeluaran')->group(function () {
        Route::post('bku-bendahara-pengeluaran', 'ReportBendaharaPengeluaranController@bkuBendahara')->name('report.bku.pengeluaran');
        Route::post('spj-pengeluaran', 'ReportBendaharaPengeluaranController@spjPengeluaran')->name('report.spj.pengeluaran');
        Route::post('register-bendahara-pengeluaran', 'ReportBendaharaPengeluaranController@registerBendaharaPengeluaran')->name('report.registerbendahara.pengeluaran');
        Route::post('buku-rincian-objek', 'ReportBendaharaPengeluaranController@brop')->name('report.brop.pengeluaran');
        Route::post('buku-pajak', 'ReportBendaharaPengeluaranController@bukuPajak')->name('report.buku.pajak');
    });

    Route::prefix('report-ppk')->group(function () {
        Route::post('realisasi-anggaran', 'ReportPPK@penjabaranRealisasiAnggaran')->name('report.ppk.lra');
        Route::post('penjabaran-anggaran', 'ReportPPK@penjabaranApbd')->name('report.ppk.penjabaran');
        Route::post('operasional', 'ReportPPK@laporanOperasional')->name('report.ppk.operasional');
        Route::post('ekuitas', 'ReportPPK@laporanEkuitas')->name('report.ppk.ekuitas');
        Route::post('neraca', 'ReportPPK@laporanNeraca')->name('report.ppk.neraca');
        Route::post('perubahan-sal', 'ReportPPK@laporanSal')->name('report.ppk.sal');
        Route::post('arus-kas', 'ReportPPK@arusKas')->name('report.ppk.aruskas');
    });


    Route::prefix('ajax')->group(function () {
        Route::get('pejabat-unit', 'PejabatUnitController@getData')->name('admin.pejabatunit.data');
        Route::get('akunRba1', 'AkunController@getAkunRba1')->name('admin.akun.rba1');
        Route::get('akunRba221', 'AkunController@getAkunRba221')->name('admin.akun.rba221');
        Route::get('kegiatanRba221', 'AkunController@getKegiatanRba221')->name('admin.akun.kegiatanrba221');
        Route::get('rekening-sts', 'StsController@getData')->name('admin.sts.data');
        Route::get('rekeningbendahara', 'RekeningBendaharaController@getData')->name('admin.rekeningbendahara.data');
        Route::get('pihak-ketiga', 'PihakKetigaController@getData')->name('admin.pihakketiga.data');
        Route::get('pihak-ketiga/detail', 'PihakKetigaController@getDetailData')->name('admin.pihakketiga.detail');
        Route::get('akun/kegiatan', 'AkunController@getAkunByKegiatan')->name('admin.akun.kegiatan');
        Route::post('tbp', 'TbpController@store')->name('admin.tbp.save');
        Route::post('sts', 'StsController@store')->name('admin.sts.save');
        Route::post('bku', 'BkuController@store')->name('admin.bku.save');
        Route::post('spd', 'SPDController@store')->name('admin.spd.save');
        Route::post('bast', 'BASTController@store')->name('admin.bast.save');
        Route::post('spp', 'SPPController@store')->name('admin.spp.save');
        Route::post('sp3b', 'SP3BPController@store')->name('admin.sp3b.save');
        Route::post('setup-jurnal', 'SetupJurnalController@store')->name('admin.setup_jurnal.save');
        Route::get('spd/sisa-spd', 'SPDController@getSisaSpd')->name('admin.spd.getSisaSpd');
        Route::get('bast/data', 'BASTController@getData')->name('admin.bast.data');
        Route::get('bast/kegiatan', 'BASTController@getKegiatanBast')->name('admin.bast.kegiatan');
        Route::get('spp/getpagu', 'SPPController@getPagu')->name('admin.spp.getpagu');
        Route::get('spp/getpagukegiatan', 'SPPController@getPaguKegiatan')->name('admin.spp.getkegiatanpengajuan');
        Route::get('spd/data', 'SPDController@getData')->name('admin.spd.data');
        Route::get('sp2d/data', 'SP2DController@getData')->name('admin.sp2d.data');
        Route::get('sp2d/data-kontrapos', 'SP2DController@getDataKontrapos')->name('admin.sp2d.kontrapos');
        Route::get('setor-pajak/data', 'SetorPajakController@getData')->name('admin.setor_pajak.data');
        Route::get('setor-pajak/datapajak', 'SetorPajakController@getDataPajakPotongan')->name('admin.setor_pajak.datapajak');
        Route::get('kontrapos/data', 'KontraposController@getData')->name('admin.kontrapos.data');
        Route::post('saldo-awal/lo/store', 'SaldoAwalLoController@store')->name('admin.saldo_lo.save');
        Route::post('saldo-awal/neraca/store', 'SaldoAwalNeracaController@store')->name('admin.saldo_neraca.save');
        Route::post('kontrapos-store', 'KontraposController@store')->name('admin.kontrapos.save');
        Route::get('sp3b-rincian', 'SP3BPController@dataRincian')->name('admin.rinciansp3b.data');
        Route::get('rincian-akun-rba221', 'LaporanController@getDataRekeningPengeluaran')->name('admin.rincianakun.rba221');
        Route::get('rincian-akun-rba1', 'LaporanController@getDataRekeningPenerimaan')->name('admin.rincianakun.rba1');
    });

    Route::prefix('pengaturan')->group(function () {
        Route::get('prefix-penomoran', 'PrefixPenomoranController@index')->name('admin.prefix.index');
        Route::put('prefix-penomoran/edit', 'PrefixPenomoranController@update')->name('admin.prefix.update');
    });

    Route::prefix('organisasi')->group(function () {
        // fungsi
        Route::get('fungsi', 'FungsiController@index')->name('admin.fungsi.index');
        Route::post('fungsi/buat', 'FungsiController@store')->name('admin.fungsi.store');
        Route::put('fungsi/edit', 'FungsiController@update')->name('admin.fungsi.update');
        Route::delete('fungsi/hapus', 'FungsiController@destroy')->name('admin.fungsi.destroy');

        // urusan
        Route::get('urusan', 'UrusanController@index')->name('admin.urusan.index');
        Route::post('urusan/buat', 'UrusanController@store')->name('admin.urusan.store');
        Route::put('urusan/edit', 'UrusanController@update')->name('admin.urusan.update');
        Route::delete('urusan/hapus', 'UrusanController@destroy')->name('admin.urusan.destroy');

        // bidang
        Route::get('bidang', 'BidangController@index')->name('admin.bidang.index');
        Route::post('bidang/buat', 'BidangController@store')->name('admin.bidang.store');
        Route::put('bidang/edit', 'BidangController@update')->name('admin.bidang.update');
        Route::delete('bidang/hapus', 'BidangController@destroy')->name('admin.bidang.destroy');

        // program
        Route::get('program', 'ProgramController@index')->name('admin.program.index');
        Route::post('program/buat', 'ProgramController@store')->name('admin.program.store');
        Route::put('program/edit', 'ProgramController@update')->name('admin.program.update');
        Route::delete('program/hapus', 'ProgramController@destroy')->name('admin.program.destroy');

        // kegiatan
        Route::get('kegiatan', 'KegiatanController@index')->name('admin.kegiatan.index');
        Route::post('kegiatan/buat', 'KegiatanController@store')->name('admin.kegiatan.store');
        Route::put('kegiatan/edit', 'KegiatanController@update')->name('admin.kegiatan.update');
        Route::delete('kegiatan/hapus', 'KegiatanController@destroy')->name('admin.kegiatan.destroy');

        // opd
        Route::get('opd', 'OpdController@index')->name('admin.opd.index');
        Route::post('opd/buat', 'OpdController@store')->name('admin.opd.store');
        Route::put('opd/edit', 'OpdController@update')->name('admin.opd.update');
        Route::delete('opd/hapus', 'OpdController@destroy')->name('admin.opd.destroy');

        // unit kerja
        Route::get('unit-kerja', 'UnitKerjaController@index')->name('admin.unit_kerja.index');
        Route::post('unit-kerja/buat', 'UnitKerjaController@store')->name('admin.unit_kerja.store');
        Route::put('unit-kerja/edit', 'UnitKerjaController@update')->name('admin.unit_kerja.update');
        Route::delete('unit-kerja/hapus', 'UnitKerjaController@destroy')->name('admin.unit_kerja.destroy');

        // pejabat unit
        Route::get('pejabat-unit', 'PejabatUnitController@index')->name('admin.pejabat_unit.index');
        Route::post('pejabat-unit/buat', 'PejabatUnitController@store')->name('admin.pejabat_unit.store');
        Route::put('pejabat-unit/edit', 'PejabatUnitController@update')->name('admin.pejabat_unit.update');
        Route::delete('pejabat-unit/hapus', 'PejabatUnitController@destroy')->name('admin.pejabat_unit.destroy');

        Route::get('pemetaan-akun', 'MapAkunFinanceController@index')->name('admin.pemetaan_akun.index');
        Route::post('pemetaan-akun/buat', 'MapAkunFinanceController@store')->name('admin.pemetaan_akun.store');
        Route::put('pemetaan-akun/edit', 'MapAkunFinanceController@update')->name('admin.pemetaan_akun.update');
        Route::delete('pemetaan-akun/hapus', 'MapAkunFinanceController@destroy')->name('admin.pemetaan_akun.destroy');
    });

    Route::prefix('data-dasar')->group(function () {
        // pejabat daerah
        Route::get('pejabat-daerah', 'PejabatDaerahController@index')->name('admin.pejabat.index');
        Route::post('pejabat-daerah/buat', 'PejabatDaerahController@store')->name('admin.pejabat.store');
        Route::put('pejabat-daerah/edit', 'PejabatDaerahController@update')->name('admin.pejabat.update');
        Route::delete('pejabat-daerah/hapus', 'PejabatDaerahController@destroy')->name('admin.pejabat.destroy');

        // kategori akun
        Route::get('kategori-akun', 'KategoriAkunController@index')->name('admin.kategoriakun.index');
        Route::post('kategori-akun/buat', 'KategoriAkunController@store')->name('admin.kategoriakun.store');
        Route::put('kategori-akun/edit', 'KategoriAkunController@update')->name('admin.kategoriakun.update');
        Route::delete('kategori-akun/hapus', 'KategoriAkunController@destroy')->name('admin.kategoriakun.destroy');  

        // akun
        Route::get('akun', 'AkunController@index')->name('admin.akun.index');
        Route::post('akun/buat', 'AkunController@store')->name('admin.akun.store');
        Route::put('akun/edit', 'AkunController@update')->name('admin.akun.update');
        Route::delete('akun/hapus', 'AkunController@destroy')->name('admin.akun.destroy');

        // pemetaan akun
        Route::get('pemetaan-akun', 'MapAkunController@index')->name('admin.map_akun.index');
        Route::post('pemetaan-akun/buat', 'MapAkunController@store')->name('admin.map_akun.store');
        Route::put('pemetaan-akun/edit', 'MapAkunController@update')->name('admin.map_akun.update');
        Route::delete('pemetaan-akun/hapus', 'MapAkunController@destroy')->name('admin.map_akun.destroy');

        // pemetaan kegiatan
        Route::get('pemetaan-kegiatan', 'MapKegiatanController@index')->name('admin.map_kegiatan.index');
        Route::post('pemetaan-kegiatan/buat', 'MapKegiatanController@store')->name('admin.map_kegiatan.store');
        Route::put('pemetaan-kegiatan/edit', 'MapKegiatanController@update')->name('admin.map_kegiatan.update');
        Route::delete('pemetaan-kegiatan/hapus', 'MapKegiatanController@destroy')->name('admin.map_kegiatan.destroy');

        // sumber dana
        Route::get('sumber-dana', 'SumberDanaController@index')->name('admin.sumber_dana.index');
        Route::post('sumber-dana/buat', 'SumberDanaController@store')->name('admin.sumber_dana.store');
        Route::put('sumber-dana/edit', 'SumberDanaController@update')->name('admin.sumber_dana.update');
        Route::delete('sumber-dana/hapus', 'SumberDanaController@destroy')->name('admin.sumber_dana.destroy');

        // standard satuan harga
        Route::get('ssh', 'SSHController@index')->name('admin.ssh.index');
        Route::post('ssh/buat', 'SSHController@store')->name('admin.ssh.store');
        Route::put('ssh/edit', 'SSHController@update')->name('admin.ssh.update');
        Route::delete('ssh/hapus', 'SSHController@destroy')->name('admin.ssh.destroy');
    
        // rekening bendahara
        Route::get('rekening-bendahara', 'RekeningBendaharaController@index')->name('admin.rekening_bendahara.index');
        Route::post('rekening-bendahara/buat', 'RekeningBendaharaController@store')->name('admin.rekening_bendahara.store');
        Route::put('rekening-bendahara/edit', 'RekeningBendaharaController@update')->name('admin.rekening_bendahara.update');
        Route::delete('rekening-bendahara/hapus', 'RekeningBendaharaController@destroy')->name('admin.rekening_bendahara.destroy');

        // pajak
        Route::get('pajak', 'PajakController@index')->name('admin.pajak.index');
        Route::post('pajak/buat', 'PajakController@store')->name('admin.pajak.store');
        Route::put('pajak/edit', 'PajakController@update')->name('admin.pajak.update');
        Route::delete('pajak/hapus', 'PajakController@destroy')->name('admin.pajak.destroy');
    });

    Route::prefix('pendapatan')->group(function () {
        // tbp 
        Route::get('tbp', 'TbpController@index')->name('admin.tbp.index');
        Route::get('tbp/create', 'TbpController@create')->name('admin.tbp.create');
        Route::post('tbp/store', 'TbpController@store')->name('admin.tbp.store');
        Route::get('tbp/edit/{id}', 'TbpController@edit')->name('admin.tbp.edit');
        Route::put('tbp/update/{id}', 'TbpController@update')->name('admin.tbp.update');
        Route::delete('tbp/hapus', 'TbpController@destroy')->name('admin.tbp.destroy');
        Route::get('report/tbp/{id}', 'TbpController@report')->name('admin.tbp.report');
        Route::get('report/tbp/excel/{id}', 'TbpController@reportExcel')->name('admin.tbp.reportExcel');

        // sts 
        Route::get('sts', 'StsController@index')->name('admin.sts.index');
        Route::get('sts/create', 'StsController@create')->name('admin.sts.create');
        Route::post('sts/store', 'StsController@store')->name('admin.sts.store');
        Route::get('sts/edit/{id}', 'StsController@edit')->name('admin.sts.edit');
        Route::put('sts/update/{id}', 'StsController@update')->name('admin.sts.update');
        Route::delete('sts/hapus', 'StsController@destroy')->name('admin.sts.destroy');
        Route::get('report/sts/{id}', 'StsController@report')->name('admin.sts.report');
        Route::get('report/sts/excel/{id}', 'StsController@reportExcel')->name('admin.sts.reportExcel');
    });

    Route::prefix('belanja')->group(function () {
        // bast 
        Route::get('bast', 'BASTController@index')->name('admin.bast.index');
        Route::get('bast/create', 'BASTController@create')->name('admin.bast.create');
        Route::get('bast/edit/{id}', 'BASTController@edit')->name('admin.bast.edit');
        Route::put('bast/update/{id}', 'BASTController@update')->name('admin.bast.update');
        Route::delete('bast/hapus', 'BASTController@destroy')->name('admin.bast.destroy');


        // spd
        Route::get('spd', 'SPDController@index')->name('admin.spd.index');
        Route::get('spd/create', 'SPDController@create')->name('admin.spd.create');
        Route::get('spd/edit/{id}', 'SPDController@edit')->name('admin.spd.edit');
        Route::put('spd/update/{id}', 'SPDController@update')->name('admin.spd.update');
        Route::delete('spd/hapus', 'SPDController@destroy')->name('admin.spd.destroy');
        Route::get('report/spd/{id}', 'SPDController@report')->name('admin.spd.report');
        
        // spp
        Route::get('spp', 'SPPController@index')->name('admin.spp.index');
        Route::get('spp/create', 'SPPController@create')->name('admin.spp.create');
        Route::get('spp/edit/{id}', 'SPPController@edit')->name('admin.spp.edit');
        Route::put('spp/update/{id}', 'SPPController@update')->name('admin.spp.update');
        Route::delete('spp/hapus', 'SPPController@destroy')->name('admin.spp.destroy');
        Route::get('spp/report/{id}', 'SPPController@reportSpp')->name('admin.spp.report');
        Route::get('spm/report/{id}', 'SPPController@reportSpm')->name('admin.spm.report');

        // pihak ketiga
        Route::get('pihak-ketiga', 'PihakKetigaController@index')->name('admin.pihak_ketiga.index');
        Route::post('pihak-ketiga/buat', 'PihakKetigaController@store')->name('admin.pihak_ketiga.store');
        Route::put('pihak-ketiga/edit', 'PihakKetigaController@update')->name('admin.pihak_ketiga.update');
        Route::delete('pihak-ketiga/hapus', 'PihakKetigaController@destroy')->name('admin.pihak_ketiga.destroy');

        // verifikasi spp
        Route::get('verifikasi-spp', 'VerifikasiSPPController@index')->name('admin.verifikasispp.index');
        Route::put('verifikasi-spp/update', 'VerifikasiSPPController@update')->name('admin.verifikasispp.update');

        // sp2d
        Route::get('sp2d', 'SP2DController@index')->name('admin.sp2d.index');
        Route::get('sp2d/detail/{id}', 'SP2DController@show')->name('admin.sp2d.show');
        Route::get('sp2d/cetak/{id}', 'SP2DController@report')->name('admin.sp2d.report');

        // setor pajak
        Route::get('setor-pajak', 'SetorPajakController@index')->name('admin.setor_pajak.index');
        Route::get('setor-pajak/detail/{id}', 'SetorPajakController@show')->name('admin.setor_pajak.show');
        Route::put('setor-pajak/update', 'SetorPajakController@update')->name('admin.setor_pajak.update');

    });

    // pengembalian
    Route::prefix('pengembalian')->group(function () {
        Route::get('kontrapos', 'KontraposController@index')->name('admin.kontrapos.index');
        Route::get('kontrapos/create', 'KontraposController@create')->name('admin.kontrapos.create');
        Route::get('kontrapos/edit/{id}', 'KontraposController@edit')->name('admin.kontrapos.edit');
        Route::put('kontrapos/update/{id}', 'KontraposController@update')->name('admin.kontrapos.update');
        Route::delete('kontrapos/hapus', 'KontraposController@destroy')->name('admin.kontrapos.destroy');
    });

    // SP3BP
    Route::prefix('sp3bp')->group(function () {
        Route::get('/', 'SP3BPController@index')->name('admin.sp3bp.index');
        Route::get('create', 'SP3BPController@create')->name('admin.sp3bp.create');
        Route::get('edit/{id}', 'SP3BPController@edit')->name('admin.sp3bp.edit');
        Route::delete('hapus', 'SP3BPController@destroy')->name('admin.sp3bp.destroy');
        Route::put('update/{id}', 'SP3BPController@update')->name('admin.sp3bp.update');
        Route::get('verifikasi-sp3b', 'SP3BPController@verificationView')->name('admin.sp3bp.verificationview');
        Route::put('verifikasi-sp3b', 'SP3BPController@verification')->name('admin.sp3bp.verification');
        Route::get('report/{id}', 'SP3BPController@reportSp3b')->name('admin.sp3bp.reportsp3b');
        Route::get('report/{id}/{jenis}', 'SP3BPController@reportSp3b')->name('admin.sp3bp.reportsp2b');
        Route::get('report/sptj/{id}/cetak', 'SP3BPController@reportSptj')->name('admin.sp3bp.reportsptj');
    });

    // akuntansi
    Route::prefix('akuntansi')->group(function () {
        Route::get('jurnal-penyesuaian', 'JurnalPenyesuaianController@index')->name('admin.jurnal_penyesuaian.index');
        Route::get('jurnal-penyesuaian/create', 'JurnalPenyesuaianController@create')->name('admin.jurnal_penyesuaian.create');
        Route::get('jurnal-penyesuaian/edit/{id}', 'JurnalPenyesuaianController@edit')->name('admin.jurnal_penyesuaian.edit');
        Route::delete('jurnal-penyesuaian/delete', 'JurnalPenyesuaianController@destroy')->name('admin.jurnal_penyesuaian.destroy');
        Route::get('jurnal-penyesuaian/akun', 'JurnalPenyesuaianController@getAkun')->name('admin.jurnal_penyesuaian.akun');
        Route::post('jurnal-penyesuaian/store', 'JurnalPenyesuaianController@store')->name('admin.jurnal_penyesuaian.save');
        Route::put('jurnal-penyesuaian/update/{id}', 'JurnalPenyesuaianController@update')->name('admin.jurnal_penyesuaian.update');

        Route::get('saldo-awal/lo', 'SaldoAwalLoController@index')->name('admin.saldo_lo.index');
        Route::get('saldo-awal/lo/create', 'SaldoAwalLoController@create')->name('admin.saldo_lo.create');
        Route::get('saldo-awal/lo/edit/{id}', 'SaldoAwalLoController@edit')->name('admin.saldo_lo.edit');
        Route::delete('saldo-awal/lo/delete', 'SaldoAwalLoController@destroy')->name('admin.saldo_lo.destroy');
        Route::put('saldo-awal/lo/update/{id}', 'SaldoAwalLoController@update')->name('admin.saldo_lo.update');

        Route::get('saldo-awal/neraca', 'SaldoAwalNeracaController@index')->name('admin.saldo_neraca.index');
        Route::get('saldo-awal/neraca/create', 'SaldoAwalNeracaController@create')->name('admin.saldo_neraca.create');
        Route::get('saldo-awal/neraca/edit/{id}', 'SaldoAwalNeracaController@edit')->name('admin.saldo_neraca.edit');
        Route::delete('saldo-awal/neraca/delete', 'SaldoAwalNeracaController@destroy')->name('admin.saldo_neraca.destroy');
        Route::put('saldo-awal/neraca/update/{id}', 'SaldoAwalNeracaController@update')->name('admin.saldo_neraca.update');
    
        Route::get('jurnal-umum', 'JurnalUmumController@index')->name('admin.jurnal_umum.index');

        Route::get('setup-jurnal', 'SetupJurnalController@index')->name('admin.setup_jurnal.index');
        Route::get('setup-jurnal/buat', 'SetupJurnalController@create')->name('admin.setup_jurnal.create');
        Route::get('setup-jurnal/edit/{id}', 'SetupJurnalController@edit')->name('admin.setup_jurnal.edit');
        Route::delete('setup-jurnal/hapus', 'SetupJurnalController@destroy')->name('admin.setup_jurnal.destroy');
        Route::put('setup-jurnal/ubah/{id}', 'SetupJurnalController@update')->name('admin.setup_jurnal.update');
    });

    // bku 
    Route::get('bku', 'BkuController@index')->name('admin.bku.index');
    Route::get('bku/create', 'BkuController@create')->name('admin.bku.create');
    Route::post('bku/store', 'BkuController@store')->name('admin.bku.store');
    Route::get('bku/edit/{id}', 'BkuController@edit')->name('admin.bku.edit');
    Route::put('bku/update/{id}', 'BkuController@update')->name('admin.bku.update');
    Route::delete('bku/hapus', 'BkuController@destroy')->name('admin.bku.destroy');
    Route::get('report/bku/{id}', 'BkuController@report')->name('admin.bku.report');
    Route::get('report/bku/excel/{id}', 'BkuController@reportExcel')->name('admin.bku.reportExcel');

    Route::get('laporan', 'LaporanController@index')->name('admin.laporan.index');
});
