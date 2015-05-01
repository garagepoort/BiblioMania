<?php

class FileToExtraBookInfoParametersMapper {

    public function map($line_values){
        return new ExtraBookInfoParameters($line_values[LineMapping::ExtraBookInfoPages],
            $line_values[LineMapping::ExtraBookInfoPrint],
            "",
            "");
    }
}