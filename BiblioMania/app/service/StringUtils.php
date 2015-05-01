<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 01/05/15
 * Time: 11:55
 */

class StringUtils {

    public static function emptyToNull($string)
    {
        if (trim($string) === '')
            $string = null;

        return $string;
    }
}