<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class DateToJsonMapper
{

    public function mapToJson($date){
        if($date instanceof Date){
            return array(
                "day"=>$date->day,
                "month"=>$date->month,
                "year"=>$date->year,
            );
        }else if(!StringUtils::isEmpty($date)){
            $dateTime = DateTime::createFromFormat("Y-m-d", $date);
            $timestamp = $dateTime->getTimestamp();
            return array(
                "day"=>date('d', $timestamp),
                "month"=>date('m', $timestamp),
                "year"=>date('Y', $timestamp),
            );
        }
    }
}