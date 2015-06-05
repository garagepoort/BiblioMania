<?php

class FileToBookParametersMapper {
    /** @var  DateImporter */
    private $dateImporter;

    function __construct()
    {
        $this->dateImporter = App::make('DateImporter');
    }


    public function map($line_values){
        $publicationDate = $this->dateImporter->importDate($line_values[LineMapping::BookPublicationDate]);
        $genreId = 1;

        $language = new Language();
        $language->name = $line_values[LineMapping::BookLanguage];


        $bookRetailPrice = $line_values[LineMapping::BookRetailPrice];
        if(count(explode(" ", $line_values[LineMapping::BookRetailPrice])) > 1){
            $bookRetailPrice = explode(" ", $line_values[LineMapping::BookRetailPrice])[1];
        }

        return new BookInfoParameters(
            null,
            $line_values[LineMapping::BookTitle],
            $line_values[LineMapping::BookSubtitle],
            $line_values[LineMapping::BookISBN],
            $genreId,
            $publicationDate,
            $line_values[LineMapping::BookPublisher],
            $line_values[LineMapping::BookPublisherCountry],
            $language,
            $bookRetailPrice);
    }

}