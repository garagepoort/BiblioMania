<?php

class FileToExtraBookInfoParametersMapper {

    public function map($line_values){
        return new ExtraBookInfoParameters($line_values[LineMapping::$ExtraBookInfoPages],
            $line_values[LineMapping::$ExtraBookInfoPrint],
            "",
            "",
            $line_values[LineMapping::$ExtraBookInfoTranslator],
            $line_values[LineMapping::$BookSummary],
            $line_values[LineMapping::$BookState],
            $line_values[LineMapping::$ExtraBookInfoTags]);
    }
}