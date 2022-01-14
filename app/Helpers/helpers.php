<?php


// fungsi untuk convert mata uang ke IDR
if ( ! function_exists('money_format')) {

    /*
    * money format
    *
    * @param mixed $str
    * @return void
    */

    function moneyFormat($str) {
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}


// fungsi untuk convert tanggal ke bahasa indonesia
if ( ! function_exists('money_format')) {

    /*
    * money format
    *
    * @param mixed $tanggal
    * @return void
    */

    function dateID($tanggal) {
        $value = Carbon\Carbon::parse($tanggal);
        $parse = $value->locale('id');
        return $parse->translatedFormat('l, d F Y');
    }
}