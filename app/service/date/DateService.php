<?php

class DateService
{

    private $logger;

    public function __construct(){
        $this->logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
    }

    public function create(DateRequest $dateRequest)
    {
        $date = new Date(array(
            'day' => $dateRequest->getDay(),
            'month' => $dateRequest->getMonth(),
            'year' => $dateRequest->getYear()));
        $date->save();
        return $date;
    }

    public function createDate($day, $month, $year)
    {
        $date = new Date(array('day' => $day, 'month' => $month, 'year' => $year));
        $date->save();
        return $date;
    }

    public function copyDateValues($date, $dateToCopy){
        $date->day = $dateToCopy->day;
        $date->month = $dateToCopy->month;
        $date->year = $dateToCopy->year;
        $date->save();
    }

//  dd-mm-yyyy format
    public function createDateFromString($dateString){
        $day = null;
        $month = null;
        $year = null;
        $dates = explode('-', $dateString);

        if(count($dates) == 1){
            $year = $dates[0];
        }else if(count($dates) == 2){
            $month = $dates[0];
            $year = $dates[1];
        }else if(count($dates) == 3){
            $day = $dates[0];
            $month = $dates[1];
            $year = $dates[2];
        }

        return $this->createDate($day, $month, $year);
    }

    public function createStringFromDate($date){
        if($date != null){
            $result = '';
            if(!empty($date->year)){
                $result = $date->year;
            }
            if(!empty($date->month)){
                $result = $date->month . '-' . $result;
            }
            if(!empty($date->day)){
                $result = $date->day . '-' . $result;
            }
            return $result;
        }
        return null;
    }

    public function createDateFromDateTime($dateTime)
    {
        $date = new Date(array(
            'day' => $dateTime->format('d'),
            'month' => $dateTime->format('m'),
            'year' => $dateTime->format('Y')
        ));
        $date->save();
        return $date;
    }

    public function getDays()
    {
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            array_push($days, $i);
        }
        return $days;
    }

    public function getMonths()
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            array_push($months, $i);
        }
        return $months;
    }

}