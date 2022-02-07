<?php


// fungsi untuk convert mata uang ke IDR
if (!function_exists('moneyFormat')) {
    function moneyFormat($str)
    {
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}


// fungsi untuk convert tanggal ke bahasa indonesia
if (!function_exists('dateID')) {
    function dateID($tanggal)
    {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}
