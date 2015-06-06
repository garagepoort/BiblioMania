<?php

class FileToAuthorParametersMapper {

    /** @var  FileToOeuvreParametersMapper */
    private $fileToOeuvreParametersMapper;

    function __construct()
    {
        $this->fileToOeuvreParametersMapper = App::make('FileToOeuvreParametersMapper');
    }


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
            $this->fileToOeuvreParametersMapper->map($line_values[LineMapping::AuthorOeuvre]),
            ImageSaveType::PATH);
        array_push($authorParameters, $firstAuthorParameters);

        $secondAuthorParameters = $this->createEmptyAuthor($line_values[LineMapping::SecondAuthorName], $line_values[LineMapping::SecondAuthorFirstName], $line_values[LineMapping::SecondAuthorInfix]);
        $thirdAuthorParameters = $this->createEmptyAuthor($line_values[LineMapping::ThirdAuthorName], $line_values[LineMapping::ThirdAuthorFirstName], $line_values[LineMapping::ThirdAuthorInfix]);

        if ($secondAuthorParameters) {
            array_push($authorParameters, $secondAuthorParameters);
        }
        if ($thirdAuthorParameters) {
            array_push($authorParameters, $thirdAuthorParameters);
        }

        return $authorParameters;
    }

    private function createEmptyAuthor($name, $firstName, $infix){
        if (!empty($firstName) || !empty($name)) {
            return new AuthorInfoParameters(
                $name,
                $firstName,
                $infix,
                new Date(),
                new Date(),
                null,
                null,
                array(),
                false);
        }
        return false;
    }
}