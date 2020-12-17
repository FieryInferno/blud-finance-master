<?php
if ( ! function_exists('full_date')) {
    function full_date($date){
        $split = explode('-', $date);
        $bulan = $split[1];

         switch ($bulan) {
            case '01':
                $bulan = 'Januari';
                break;
            case '02':
                $bulan = 'Februari';
                break;
            case '03':
                $bulan = 'Maret';
                break;
            case '04':
                $bulan = 'April';
                break;
            case '05':
                $bulan = 'Mei';
                break;
            
            case '06':
                $bulan = 'Juni';
                break;
            
            case '07':
                $bulan = 'Juli';
                break;
            
            case '08':
                $bulan = 'Agustus';
                break;
            case '09':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'Undefined';
                break;
        }
        return $split[0] . ' ' . $bulan . ' ' . $split[2];
    }
}

if (!function_exists('report_date')) {
    function report_date($date)
    {
        $split = explode('-', $date);
        $bulan = $split[1];

        switch ($bulan) {
            case '01':
                $bulan = 'Januari';
                break;
            case '02':
                $bulan = 'Februari';
                break;
            case '03':
                $bulan = 'Maret';
                break;
            case '04':
                $bulan = 'April';
                break;
            case '05':
                $bulan = 'Mei';
                break;

            case '06':
                $bulan = 'Juni';
                break;

            case '07':
                $bulan = 'Juli';
                break;

            case '08':
                $bulan = 'Agustus';
                break;
            case '09':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'Undefined';
                break;
        }
        return $split[2] . ' ' . $bulan . ' ' . $split[0];
    }
}

if (! function_exists('bulan')) {
    function bulan($bulan)
    {

        switch ($bulan) {
            case '01':
                $bulan = 'Januari';
                break;
            case '02':
                $bulan = 'Februari';
                break;
            case '03':
                $bulan = 'Maret';
                break;
            case '04':
                $bulan = 'April';
                break;
            case '05':
                $bulan = 'Mei';
                break;

            case '06':
                $bulan = 'Juni';
                break;

            case '07':
                $bulan = 'Juli';
                break;

            case '08':
                $bulan = 'Agustus';
                break;
            case '09':
                $bulan = 'September';
                break;
            case '10':
                $bulan = 'Oktober';
                break;
            case '11':
                $bulan = 'November';
                break;
            case '12':
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'Undefined';
                break;
        }

        return $bulan;
    }
}

if (! function_exists('report_tanggal')) {
    function report_tanggal($date)
    {
        $split = explode('-', $date);
        return $split['2'] . '/' . $split[1] . '/' . $split[0];
    }
}