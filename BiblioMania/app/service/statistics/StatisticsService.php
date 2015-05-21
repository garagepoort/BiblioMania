<?php

class StatisticsService {

    /** @var  StatisticsRepository */
    private $statisticsRepository;

    function __construct()
    {
        $this->statisticsRepository = App::make('StatisticsRepository');
    }

    public function getAmountBooksReadInMonth($month, $year)
    {
        return $this->statisticsRepository->getAmountBooksReadInMonth($month, $year);
    }

    public function getAmountBooksRetrievedInMonth($month, $year)
    {
        return $this->statisticsRepository->getAmountBooksRetrievedInMonth($month, $year);
    }
}