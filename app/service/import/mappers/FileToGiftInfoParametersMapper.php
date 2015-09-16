<?php

class FileToGiftInfoParametersMapper {

    public function map($line_values){
        $date = DateTime::createFromFormat('d/m/Y', $line_values[LineMapping::$GiftInfoDate]);
        if ($date == false) {
            $date = null;
        }

        return new GiftInfoParameters($date, $line_values[LineMapping::$GiftInfoFrom], "", "");
    }
}