<?php

class DateRequestTestImpl implements DateRequest {

    private $day = '31';

    private $month = '12';

    private $year = '2015';

    function getDay()
    {
        return $this->day;
    }

    function getMonth()
    {
        return $this->month;
    }

    function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @param string $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @param string $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }


}