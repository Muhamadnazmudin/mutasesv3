<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('tgl_indo_teks')) {
    function tgl_indo_teks($tgl)
    {
        if (!$tgl || $tgl == '0000-00-00') return '-';

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        $exp = explode('-', $tgl); // yyyy-mm-dd
        return ltrim($exp[2], '0') . ' ' . $bulan[(int)$exp[1]] . ' ' . $exp[0];
    }
}

