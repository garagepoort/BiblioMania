<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 12/04/15
 * Time: 19:22
 */

class FileToFirstPrintParametersMapper {
    /** @var  DateImporter */
    private $dateImporter;

    function __construct()
    {
        $this->dateImporter = App::make('DateImporter');
    }


    public function map($line_values, $original_book_title){

        $language = new Language();
        $language->name = $line_values[LineMapping::FirstPrintLanguage];

        $country = new Country();
        $country->name = $line_values[LineMapping::FirstPrintCountry];

        $firstPrintPublicationDate = $this->dateImporter->getPublicationDate($line_values[LineMapping::FirstPrintPublicationDate]);
        $firstPrintPublisherName = $line_values[LineMapping::FirstPrintPublisherName];
        $firstPrintTitle = $line_values[LineMapping::FirstPrintTitle];

        if(empty($firstPrintTitle)){
            $firstPrintTitle = $original_book_title;
        }

        return new FirstPrintInfoParameters($firstPrintTitle, "", "", $firstPrintPublicationDate, $firstPrintPublisherName, $language, $country);
    }
}