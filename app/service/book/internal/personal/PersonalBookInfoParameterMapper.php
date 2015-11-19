<?php

class PersonalBookInfoParameterMapper {

    public function create(){
        $string_reading_dates = explode(",", Input::get('personal_info_reading_dates'));
        $reading_dates = array();
        foreach ($string_reading_dates as $string_reading_date) {
            if ($string_reading_date != null) {
                $dateTime = DateTime::createFromFormat('d/m/Y', $string_reading_date);
                if($dateTime){
                    array_push($reading_dates, $dateTime);
                }
            }
        }

        return new PersonalBookInfoParameters(
            Input::get('personal_info_owned'),
            Input::get('personal_info_reason_not_owned'),
            Input::get('personal_info_review'),
            Input::get('personal_info_rating'),
            $reading_dates);
    }
}