<?php
use Bendani\PhpCommon\Utils\StringUtils;

/**
 * Created by PhpStorm.
 * User: david
 * Date: 22/06/15
 * Time: 23:03
 */

class FileToTagMapper {

    public function mapToTag($line_values)
    {
        $genreLine = $line_values[LineMapping::$BookGenre];

        if (!StringUtils::isEmpty($genreLine)) {
            $genreLine = StringUtils::toLowerCase($genreLine);

            if (StringUtils::contains($genreLine, "woii")) {
                return "WOII";
            }
            if (StringUtils::contains($genreLine, "woi")) {
                return "WOI";
            }
        }
    }
}