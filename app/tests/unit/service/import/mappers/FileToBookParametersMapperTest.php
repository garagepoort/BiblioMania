<?php

class FileToBookParametersMapperTest extends TestCase {

    /** @var  FileToBookParametersMapper */
    private $fileToBookParametersMapper;
    /** @var DateService */
    private $dateImporter;
    /** @var Date */
    private $dateMock;

    public function setUp(){
        parent::setUp();
        $this->dateImporter = $this->mock('DateImporter');
        $this->fileToBookParametersMapper = App::make('FileToBookParametersMapper');

        $this->dateMock = Mockery::mock('Eloquent', 'Date');

        $values = array("Titel", "Ondertitel", "ISBN", "Omslag prijs", "Land", "Uitgever", "Taal", "Publicatie Datum");
        LineMapping::initializeMapping($values);
    }

    public function test_map_mapsCorrect(){
        $this->dateImporter->shouldReceive('importDate')->once()->with("some_date")->andReturn($this->dateMock);

        $line_values = [50];
        $line_values[LineMapping::$BookTitle] = "title";
        $line_values[LineMapping::$BookSubtitle] = "subtitle";
        $line_values[LineMapping::$BookISBN] = "1234567890123";
        $line_values[LineMapping::$BookRetailPrice] = "20";
        $line_values[LineMapping::$BookPublisherCountry] = "publisherCountry";
        $line_values[LineMapping::$BookPublisher] = "publisher";
        $line_values[LineMapping::$BookLanguage] = "bookLanguage";
        $line_values[LineMapping::$BookPublicationDate] = "some_date";

        $parameters = $this->fileToBookParametersMapper->map($line_values);

        $this->assertEquals($parameters->getTitle(), "title");
        $this->assertEquals($parameters->getSubtitle(), "subtitle");
        $this->assertEquals($parameters->getIsbn(), "1234567890123");
        $this->assertEquals($parameters->getRetailPrice(), "20");
        $this->assertEquals($parameters->getCountryName(), "publisherCountry");
        $this->assertEquals($parameters->getPublisherName(), "publisher");
        $this->assertEquals($parameters->getLanguage(), "bookLanguage");
        $this->assertEquals($parameters->getPublicationDate(), $this->dateMock);
    }
}
