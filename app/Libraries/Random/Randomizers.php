<?php
namespace App\Libraries\Random;

class Randomizer
{

    /**
     * Random String generator
     * @param  integer $length
     * @param  string  $case   none/upper/lower
     * @return string
     */
    public static function string($length = 5, $case = 'none')
    {
        $string = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )), 1, $length);

        if ($case === 'lower') return strtolower($string);
        if ($case === 'upper') return strtoupper($string);

        // clean almost identical characters
        $string = str_replace("l", "1", $string);
        $string = str_replace("o", "0", $string);
        $string = str_replace("O", "0", $string);
        $string = str_replace("i", "1", $string);

        return $string;
    }

    public static function filename()
    {
        return $imgName  = str_shuffle(sha1(strtotime(date('U'))) . md5(date("YmdHisu"))) . Randomizer::string(20);
    }
}
