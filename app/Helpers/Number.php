<?php

namespace App\Helpers;

class Number
{
    public static function format($number)
    {
        return number_format((float) $number, 0, ',', '.');
    }
}