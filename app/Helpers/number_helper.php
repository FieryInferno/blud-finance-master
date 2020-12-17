<?php

if (! function_exists('penyebut')) {
    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

if (! function_exists('terbilang')) {
    function terbilang($nilai)
    {
        $idr = explode('.', $nilai);

        $hasil = trim(penyebut($idr[0]));

        if (isset($idr[1]) && $idr[1] > 0){
            $sen = trim(penyebut($idr[1])) . ' sen ';
        }else {
            $sen = '';
        }

        return $hasil . ' ' . $sen . ' rupiah';
    }
}

if (! function_exists('nomor_fix')) {
    function nomor_fix($format, $nomor, $kode_unit_kerja){
        $nomorFix = '';
        foreach ($format as $key => $value) {
            $found = false;
            if (preg_match('/{nomor:/', $value)) {
                $awal = preg_replace("/[^0-9]/", "", $value);
                $nomorFix .= str_pad($nomor, $awal, "0", STR_PAD_LEFT);
                $found = true;
            }
            if (preg_match('/{unit_kerja}/', $value)) {
                $unitKerja = str_replace('{unit_kerja}', $kode_unit_kerja, $value);
                $nomorFix .= $unitKerja;
                $found = true;
            }
            if (preg_match('/{tahun}/', $value)) {
                $tahun = str_replace('{tahun}', env('TAHUN_ANGGARAN', 2020), $value);
                $nomorFix .= $tahun;
                $found = true;
            }
            if (preg_match('/{beban}/', $value)) {
                $beban = str_replace('{beban}', env('TAHUN_ANGGARAN', 2020), 'BL');
                $nomorFix .= $beban;
                $found = true;
            }
            if (preg_match('/{keperluan}/', $value)) {
                $keperluan = str_replace('{keperluan}', 'BL', $value);
                $nomorFix .= $keperluan;
                $found = true;
            }

            if (!$found) {
                $nomorFix .= $value;
                if ($key != count($format)) {
                    $nomorFix .= '/';
                }
            }else {
                if (isset($format[$key+1])){
                    $nomorFix .= '/';
                }
            }
        }

        return $nomorFix;
    }
}