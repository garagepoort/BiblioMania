<?php

namespace e2e\datasetbuilders;


class DateBuilder implements \DateRequest
{

    private $day;
    private $month;
    private $year;

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $day
     */
    public function withDay($day)
    {
        $this->day = $day;
        return $this;
    }

    /**
     * @param mixed $month
     */
    public function withMonth($month)
    {
        $this->month = $month;
        return $this;
    }

    /**
     * @param mixed $year
     */
    public function withYear($year)
    {
        $this->year = $year;
        return $this;
    }



}