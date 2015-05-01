<?php

class FileToPersonalBookInfoParametersMapper {

    public function map($line_values){
        $owned = $line_values[LineMapping::PersonalBookInfoInCollection] == 'In verzameling' ? true : false;
        $reading_dates = array();

        if($line_values[LineMapping::PersonalBookInfoReadingDate] != ''){
            $reading_date = DateTime::createFromFormat('d-m-y', $line_values[LineMapping::PersonalBookInfoReadingDate]);
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