<?php

class FileToAuthorParametersMapper {

    public function mapToParameters($line_values){
        $authorParameters = array();
        $coverImage = null;
        if($line_values[LineMapping::AuthorImage] != ""){
            $path = explode('\\', $line_values[LineMapping::AuthorImage]);
            $coverImage = 'bookImages/' . Auth::user()->username . '/' . end($path);
        }

        $firstAuthorParameters = new AuthorInfoParameters(
            $line_values[LineMapping::FirstAuthorName],
            $line_values[LineMapping::FirstAuthorFirstName],
            $line_values[LineMapping::FirstAuthorInfix],
            new Date(),new Date(),null,
            $coverImage,
            "",
            false);
        array_push($authorParameters, $firstAuthorParameters);

        if (!empty($line_values[LineMapping::SecondAuthorFirstName]) || !empty($line_values[LineMapping::SecondAuthorName])) {
            $secondAuthorParameters = new AuthorInfoParameters(
                $line_values[LineMapping::SecondAuthorName],
                $line_values[LineMapping::SecondAuthorFirstName],
                $line_values[LineMapping::SecondAuthorInfix], new Date(), new Date(), null, null, "", false);
            array_push($authorParameters, $secondAuthorParameters);
        }

        if (!empty($line_values[LineMapping::ThirdAuthorFirstName]) || !empty($line_values[LineMapping::ThirdAuthorName])) {
            $thirdAuthorParameters = new AuthorInfoParameters(
                $line_values[LineMapping::ThirdAuthorName],
                $line_values[LineMapping::ThirdAuthorFirstName],
                $line_values[LineMapping::ThirdAuthorInfix], new Date(), new Date(), null, null, "", false);
            array_push($authorParameters, $thirdAuthorParameters);
        }

        return $authorParameters;
    }
}