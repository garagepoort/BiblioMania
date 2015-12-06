<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

class DateFormatter {


    public static function toDateWithSlashes($date){
        return date("d/m/Y", $date);
    }

    public static function getYearFromSqlDate($date){
        $dateTime = DateTime::createFromFormat("Y-m-d", $date);
        $timestamp = $dateTime->getTimestamp();
        return StringUtils::isEmpty(date('Y', $timestamp)) ? "unknown" : date('Y', $timestamp);
    }
    
    public static function dateRequestToDateTime(DateRequest $dateRequest){
        return date_create($dateRequest->getYear() . "-" . $dateRequest->getMonth() . "-" . $dateRequest->getDay());
    }

    public static function getDateFromSqlDate($date){
        $dateTime = DateTime::createFromFormat("Y-m-d", $date);
        $timestamp = $dateTime->getTimestamp();

        $result = new Date();
        $result->day = date('d', $timestamp);
        $result->month = date('m', $timestamp);
        $result->year = date('Y', $timestamp);

        return $result;
    }
}