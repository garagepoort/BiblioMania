<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 08/07/15
 * Time: 22:29
 */

class DateFormatter {


    public static function toDateWithSlashes($date){
        return date("d/m/Y", $date);
    }
}