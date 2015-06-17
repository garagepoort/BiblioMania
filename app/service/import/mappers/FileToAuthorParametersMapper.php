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
        if($line_values[LineMapping::$AuthorImage] != ""){
            $path = explode('\\', $line_values[LineMapping::$AuthorImage]);
            $coverImage = 'bookImages/' . Auth::user()->username . '/' . end($path);
        }

        /** @var AuthorInfoParameters $firstAuthorParameters */
        $firstAuthorParameters = $this->addAuthor($line_values[LineMapping::$FirstAuthor]);
        if ($firstAuthorParameters) {
            $firstAuthorParameters = new AuthorInfoParameters(
                $firstAuthorParameters->getName(),
                $firstAuthorParameters->getFirstname(),
                $firstAuthorParameters->getInfix(),
                new Date(), new Date(), null,
                $coverImage,
                $this->fileToOeuvreParametersMapper->map($line_values[LineMapping::$AuthorOeuvre]),
                ImageSaveType::PATH);

            array_push($authorParameters, $firstAuthorParameters);
        }

        $secondAuthorParameters = $this->addAuthor($line_values[LineMapping::$SecondAuthor]);
        if ($secondAuthorParameters) {
            array_push($authorParameters, $secondAuthorParameters);
        }

        return $authorParameters;
    }

    private function addAuthor($author){
        $authorInfix = "";
        $authorName = "";
        if(!StringUtils::isEmpty($author)){
            if (StringUtils::contains($author, ',')) {
                $temp = StringUtils::split($author, ',');
                $authorName = $temp[0];
                $temp = StringUtils::split($temp[1], ' ');
                $authorFirstName = $temp[0];
                if(count($temp) >1){
                    $authorInfix = $temp[1];
                }
            }else{
                $temp = StringUtils::split($author, ' ');
                $authorFirstName = $temp[0];
                if(count($temp) > 1){
                    $authorName = $temp[1];
                }
            }
            return $this->createEmptyAuthor($authorName, $authorFirstName, $authorInfix);
        }
        return null;
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