<?php

class DateToJsonAdapter
{

    /** @var Integer */
    private $day;
    /** @var Integer */
    private $month;
    /** @var Integer */
    private $year;

    /**
     * DateToJsonAdapter constructor.
     */
    public function __construct(Date $date)
    {
        if ($date->day != 0) {
            $this->day = $date->day;
        }
        if ($date->month != 0) {
            $this->month = $date->month;
        }
        if ($date->year != 0) {
            $this->year = $date->year;
        }
    }

    public static function fromDate($date){
        return new DateToJsonAdapter(DateFormatter::getDateFromSqlDate($date));
    }

    public function mapToJson()
    {
        return array(
            "day" => $this->day,
            "month" => $this->month,
            "year" => $this->year,
        );
    }
}