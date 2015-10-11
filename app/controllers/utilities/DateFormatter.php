<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

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
    public static function getYearFromSqlDate($date){
        $dateTime = DateTime::createFromFormat("Y-m-d", $date);
        $timestamp = $dateTime->getTimestamp();
        return StringUtils::isEmpty(date('Y', $timestamp)) ? "unknown" : date('Y', $timestamp);
    }
}