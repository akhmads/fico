<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class Cast {

    public static function number( $num )
    {
        if(empty($num)) return 0;
        $num = @trim(@rtrim(@ltrim($num)));
        return preg_replace('#[^0-9\.\-]#i', '', $num);
    }

    public static function currency( $num, $decimal = 2 )
    {
        if(empty($num)) $num = 0;
        $num = self::number($num);
        return number_format($num, $decimal, '.', ',');
    }

    public static function money( $num, $decimal = 2 )
    {
        if(empty($num)) $num = 0;
        $num = self::number($num);
        return number_format($num, $decimal, '.', ',');
    }

    public static function absMoney( $num, $decimal = 2 )
    {
        if(empty($num)) $num = 0;
        $num = self::number($num);
        return str_replace('-', '', number_format($num, $decimal, '.', ','));
    }

    public static function money2( $num, $decimal = 2 )
    {
        if(empty($num)) $num = 0;
        $num = self::number($num);
        if ($num >= 0) return number_format($num, $decimal, '.', ',');
        else return '('. str_replace('-', '', number_format($num, $decimal, '.', ',')) .')';
    }
}
