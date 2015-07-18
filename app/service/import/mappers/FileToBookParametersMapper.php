<?php

class FileToBookParametersMapper {
    /** @var  DateImporter */
    private $dateImporter;
    /** @var  FileToGenreMapper */
    private $fileToGenreMapper;
    /** @var  FileToTagMapper */
    private $fileToTagMapper;
    function __construct()
    {
        $this->dateImporter = App::make('DateImporter');
        $this->fileToGenreMapper = App::make('FileToGenreMapper');
        $this->fileToTagMapper = App::make('FileToTagMapper');
    }


    public function map($line_values){
        $publicationDate = $this->dateImporter->importDate($line_values[LineMapping::$BookPublicationDate]);
        $genreId = $this->fileToGenreMapper->mapToGenre($line_values);
        $tagName = $this->fileToTagMapper->mapToTag($line_values);
        $tags = array();
        if(!StringUtils::isEmpty($tagName)){
            array_push($tags, $tagName);
        }

        $bookRetailPrice = $line_values[LineMapping::$BookRetailPrice];
        $bookRetailPrice = StringUtils::replace($bookRetailPrice, "€", "");
        $bookRetailPrice = StringUtils::replace($bookRetailPrice, " ", "");
        $bookRetailPrice = StringUtils::replace($bookRetailPrice, ",", ".");

        return new BookInfoParameters(
            null,
            $line_values[LineMapping::$BookTitle],
            $line_values[LineMapping::$BookSubtitle],
            $line_values[LineMapping::$BookISBN],
            $genreId,
            $publicationDate,
            $line_values[LineMapping::$BookPublisher],
            $line_values[LineMapping::$BookPublisherCountry],
            $line_values[LineMapping::$BookLanguage],
            $bookRetailPrice,
            $tags);
    }

}