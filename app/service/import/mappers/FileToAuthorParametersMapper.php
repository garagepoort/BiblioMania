<?php

use Bendani\PhpCommon\Utils\StringUtils;

class FileToAuthorParametersMapper {

    /** @var  FileToOeuvreParametersMapper */
    private $fileToOeuvreParametersMapper;

    function __construct()
    {
        $this->fileToOeuvreParametersMapper = App::make('FileToOeuvreParametersMapper');
    }

    public function mapToParameters($line_values){
        $authorParameters = array();
        $coverImage = "";
        if($line_values[LineMapping::$AuthorImage] != ""){
            $path = explode('\\', $line_values[LineMapping::$AuthorImage]);
            $path = StringUtils::clean(end($path));
            $path = pathinfo($path);
            $path = $path['filename'] . ".jpg";


            if(file_exists('importImages/' . $path)){
                $coverImagePath = Config::get("properties.authorImagesLocation"). "/" . $path;
                $coverImage = $path;
                copy('importImages/' . $path, $coverImagePath);
            }
        }

        /** @var AuthorInfoParameters $foundAuthorParameters */
        $authors = $line_values[LineMapping::$Authors];
        $authors = StringUtils::split($authors, ";");
        $counter = 0;
        foreach($authors as $author){
            $author = trim($author);
            $foundAuthorParameters = $this->addAuthor($author);
            if($counter == 0){
                if ($foundAuthorParameters) {
                    $foundAuthorParameters = new AuthorInfoParameters(
                        $foundAuthorParameters->getName(),
                        $foundAuthorParameters->getFirstname(),
                        $foundAuthorParameters->getInfix(),
                        new Date(), new Date(), null,
                        $coverImage,
                        $this->fileToOeuvreParametersMapper->map($line_values[LineMapping::$AuthorOeuvre]),
                        ImageSaveType::PATH);

                    array_push($authorParameters, $foundAuthorParameters);
                    $counter++;
                }
            }else{
                if ($foundAuthorParameters) {
                    array_push($authorParameters, $foundAuthorParameters);
                }
            }
        }

        return $authorParameters;
    }

    private function addAuthor($author){
        $authorFirstName = "";
        $authorInfix = "";
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
                if(count($temp) == 3){
                    $authorFirstName = $temp[0];
                    $authorInfix = $temp[1];
                    $authorName = $temp[2];
                }else if(count($temp) == 2){
                    $authorFirstName = $temp[0];
                    $authorName = $temp[1];
                }else{
                    $authorName = $temp[0];
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