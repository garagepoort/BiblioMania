<?php

class DateService
{

    private $logger;

    public function __construct(){
        $this->logger = App::make('Logger');
    }

    /**
     * @param DateRequest $dateRequest
     * @return Date
     */
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
}
