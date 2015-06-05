<?php

class FileToPersonalBookInfoParametersMapper {

    /** @var  DateImporter */
    private $dateImporter;

    function __construct()
    {
        $this->dateImporter = App::make('DateImporter');
    }


    public function map($line_values){
        $owned = $line_values[LineMapping::PersonalBookInfoInCollection] == 'In verzameling' ? true : false;
        $reading_dates = array();

        if($line_values[LineMapping::PersonalBookInfoReadingDate] != ''){
            $reading_date = $this->dateImporter->importDateToDateTime($line_values[LineMapping::PersonalBookInfoReadingDate]);
            if($reading_date != false){
                array_push($reading_dates, $reading_date);
            }
        }
        return new PersonalBookInfoParameters($owned,
            "",
            "",
            $line_values[LineMapping::PersonalBookInfoRating],
            $reading_dates);
    }
}