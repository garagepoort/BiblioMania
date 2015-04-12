<?php

class FileToAuthorParametersMapper {

    public function mapToParameters($line_values){
        $authorParameters = array();

        $firstAuthorParameters = new AuthorInfoParameters($line_values[2], $line_values[0], $line_values[1], new Date(), new Date(), null, $line_values[18], $line_values[46]);
        array_push($authorParameters, $firstAuthorParameters);

        if (!empty($line_values[5]) || !empty($line_values[3])) {
            $secondAuthorParameters = new AuthorInfoParameters($line_values[5], $line_values[3], $line_values[4], new Date(), new Date(), null, null, null);
            array_push($authorParameters, $secondAuthorParameters);
        }

        if (!empty($line_values[8]) || !empty($line_values[6])) {
            $thirdAuthorParameters = new AuthorInfoParameters($line_values[8], $line_values[6], $line_values[7], new Date(), new Date(), null, null, null);
            array_push($authorParameters, $thirdAuthorParameters);
        }

        return $authorParameters;
    }
}