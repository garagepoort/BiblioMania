<?php

class DateService
{

    public function createDate($day, $month, $year)
    {
        $date = new Date(array('day' => $day, 'month' => $month, 'year' => $year));
        $date->save();
        return $date;
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