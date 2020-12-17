<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use iio\libmergepdf\Merger;

class ReportController extends Controller
{
    public function sts()
    {
        $pdf = PDF::loadview('admin.report.form_sts');
        return $pdf->stream('report_sts.pdf', ['Attachment' => false]);   
    }

    public function tbp()
    {
        $pdf = PDF::loadview('admin.report.form_tbp');
        return $pdf->stream('report_tbp.pdf', ['Attachment' => false]);
    }

    public function spd()
    {
        $pdf = PDF::loadview('admin.report.form_spd');
        return $pdf->stream('report_spd.pdf', ['Attachment' => false]);
    }

    /**
     * Buku Pembantu Per-rincian Objek Penerimaan
     */
    public function bppop()
    {
        $pdf = PDF::loadview('admin.report.form_bppop');
        return $pdf->stream('report_bppop.pdf', ['Attachment' => false]);
    }

    public function bku_bendahara()
    {
        $pdf = PDF::loadview('admin.report.form_bku_bendahara');
        return $pdf->stream('report_bku_bendahara.pdf', ['Attachment' => false]);
    }

    public function register_sts()
    {
        $pdf = PDF::loadview('admin.report.form_register_sts');
        return $pdf->stream('report_register_sts.pdf', ['Attachment' => false]);
    }

    public function spp()
    {
        $pdf = PDF::loadview('admin.report.form_spp');
        return $pdf->stream('report_spp.pdf', ['Attachment' => false]);
    }

    public function sp2d()
    {
        $pdf = PDF::loadview('admin.report.form_sp2d');
        return $pdf->stream('report_sp2d.pdf', ['Attachment' => false]);
    }

    public function spm()
    {
        $pdf = PDF::loadview('admin.report.form_spm')->setPaper('a4', 'landscape');
        return $pdf->stream('report_spm.pdf', ['Attachment' => false]);
    }

    public function register_sts_excel()
    {
        $contents = \View::make('admin.report.form_register_sts_excel');
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report.xls');
    }

    /**
     * Buku Pembantu Per-rincian Objek Penerimaan
     */
    public function bppop_excel()
    {
        $contents = \View::make('admin.report.form_bppop_excel');
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report.xls');
    }

    public function bku_bendahara_excel()
    {
        $contents = \View::make('admin.report.form_bku_bendahara_excel');
        return \Response::make($contents, 200)
            ->header('Content-Type', 'application/vnd-ms-excel')
            ->header('Content-Disposition', 'attachment; filename=report.xls');
    }

    public function spj_pendapatan_fungsional()
    {
        $pdf = PDF::loadview('admin.report.form_spj_pendapatan_fungsional')->setPaper('a4', 'landscape');
        return $pdf->stream('report_spj_pendapatan_fungsional.pdf', ['Attachment' => false]);
    }

    public function spj_belanja_fungsional()
    {
        $pdf = PDF::loadview('admin.report.form_spj_belanja_fungsional')->setPaper('a4', 'landscape');
        return $pdf->stream('report_spj_belanja_fungsional.pdf', ['Attachment' => false]);
    }

    /**
     * Buku Pembantu Pajak
     */
    public function buku_pembantu_pajak()
    {
        $pdf = PDF::loadview('admin.report.form_buku_pembantu_pajak');
        return $pdf->stream('report_buku_pembantu_pajak', ['Attachment' => false]);
    }

    /**
     * Buku Pembantu Per Rincian Objek Penerimaan
     */
    public function buku_bppop()
    {
        $pdf = PDF::loadview('admin.report.form_buku_bppop');
        return $pdf->stream('report_buku_bppop', ['Attachment' => false]);   
    }

     /**
      * Buku Rincian Obyek Belanja Bendahara Pengeluaran
      */
    public function buku_robbp()
    {
        $pdf = PDF::loadview('admin.report.form_buku_robbp');
        return $pdf->stream('report_buku_robbp', ['Attachment' => false]);
    }

    /**
     * Form SP3B
     */
    public function sp3b()
    {
        $m = new Merger();

        $view1 = \View::make('admin.report.form_rincian_sp3b')->render();
        $view2 = \View::make('admin.report.form_rekap_sp3b')->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view1)->setPaper('a4', 'portrait');
        $m->addRaw($pdf->output());

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view2)->setPaper('a4', 'landscape');
        $m->addRaw($pdf->output());

        $userId = request()->user()->id;
        $path = storage_path() . "/app/public/sp3b_{$userId}.pdf";

        file_put_contents($path, $m->merge());

        return response()->file($path);
    }

    /**
     * Laporan Surat Pernyataan Tanggung Jawab
     */
    public function laporan_sptj()
    {
        $pdf = PDF::loadview('admin.report.form_laporan_sptj');
        return $pdf->stream('report_laporan_sptj', ['Attachment' => false]);
    }

    /**
     * Rincian Objek Belanja Bendahara Pengeluaran
     */
    public function robbp()
    {
        $pdf = PDF::loadview('admin.report.form_robbp');
        return $pdf->stream('report_robbp', ['Attachment' => false]);
    }

    public function register_spp_spm_sp2d()
    {
        $pdf = PDF::loadview('admin.report.form_register_spp_spm_sp2d')->setPaper('a4', 'landscape');
        return $pdf->stream('report_register_spp_spm_sp2d.pdf', ['Attachment' => false]);
    }

    public function realisasi_anggaran()
    {
        $pdf = PDF::loadview('admin.report.form_realisasi_anggaran');
        return $pdf->stream('report_realisasi_anggaran.pdf', ['Attachment' => false]);
    }
    
    public function penjabaran_apbd()
    {
        $pdf = PDF::loadview('admin.report.form_penjabaran_apbd')->setPaper('a4', 'landscape');
        return $pdf->stream('report_penjabaran_apbd.pdf', ['Attachment' => false]);
    }
    
    public function laporan_operasional()
    {
        $pdf = PDF::loadview('admin.report.form_laporan_operasional');
        return $pdf->stream('report_laporan_operasional.pdf', ['Attachment' => false]);
    }

    public function neraca()
    {
        $pdf = PDF::loadview('admin.report.form_neraca');
        return $pdf->stream('report_laporan_neraca.pdf', ['Attachment' => false]);
    }

    public function laporan_perubahan_ekuitas()
    {
        $pdf = PDF::loadview('admin.report.form_laporan_perubahan_ekuitas');
        return $pdf->stream('report_laporan_perubahan_ekuitas.pdf', ['Attachment' => false]);   
    }

    /**
     * Laporan Perubahan Saldo Anggaran Lebih
     */
    public function laporan_perubahan_sal()
    {
        $pdf = PDF::loadview('admin.report.form_laporan_perubahan_sal');
        return $pdf->stream('report_laporan_perubahan_sal.pdf', ['Attachment' => false]);   
    }

    public function laporan_arus_kas()
    {
        $pdf = PDF::loadview('admin.report.form_laporan_arus_kas');
        return $pdf->stream('report_laporan_arus_kas.pdf', ['Attachment' => false]);   
    }
}
