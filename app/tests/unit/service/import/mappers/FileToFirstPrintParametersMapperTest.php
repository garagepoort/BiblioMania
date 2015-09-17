<?php

class FileToFirstPrintParametersMapperTest extends TestCase
{
    /** @var  FileToFirstPrintParametersMapper */
    private $fileToFirstPrintParametersMapper;
    /** @var DateImporter */
    private $dateImporter;
    /** @var Date */
    private $dateMock;

    public function setUp()
    {
        parent::setUp();
        $this->dateImporter = $this->mock('DateImporter');
        $this->fileToFirstPrintParametersMapper = App::make('FileToFirstPrintParametersMapper');

        $this->dateMock = Mockery::mock('Eloquent', 'Date');

        $values = array(
            "Origineel Land",
            "Originele Publicatiedatum",
            "Originele Taal",
            "Originele Titel",
            "Originele Ondertitel",
            "Originele Uitgever");
        LineMapping::initializeMapping($values);
    }

    public function test_map_mapsCorrect()
    {
        $this->dateImporter->shouldReceive('importDate')->once()->with("publicationDate")->andReturn($this->dateMock);

        $line_values = [50];
        $line_values[LineMapping::$FirstPrintTitle] = "title";
        $line_values[LineMapping::$FirstPrintCountry] = "someCountry";
        $line_values[LineMapping::$FirstPrintLanguage] = "lang";
        $line_values[LineMapping::$FirstPrintPublicationDate] = "publicationDate";
        $line_values[LineMapping::$FirstPrintPublisherName] = "publisher";

        $parameters = $this->fileToFirstPrintParametersMapper->map($line_values, "orginalBook");

        $this->assertEquals($parameters->getTitle(), "title");
        $this->assertEquals($parameters->getSubtitle(), "");
        $this->assertEquals($parameters->getIsbn(), "");
        $this->assertEquals($parameters->getCountry(), "someCountry");
        $this->assertEquals($parameters->getPublisher(), "publisher");
        $this->assertEquals($parameters->getLanguage(), "lang");
        $this->assertEquals($parameters->getPublicationDate(), $this->dateMock);
    }

    public function test_map_whenTitleNotFilledIn_orginalBookTitleIsUsed()
    {
        $this->dateImporter->shouldReceive('importDate')->once()->with("publicationDate")->andReturn($this->dateMock);

        $line_values = [50];
        $line_values[LineMapping::$FirstPrintTitle] = "";
        $line_values[LineMapping::$FirstPrintCountry] = "someCountry";
        $line_values[LineMapping::$FirstPrintLanguage] = "lang";
        $line_values[LineMapping::$FirstPrintPublicationDate] = "publicationDate";
        $line_values[LineMapping::$FirstPrintPublisherName] = "publisher";

        $parameters = $this->fileToFirstPrintParametersMapper->map($line_values, "orginalBook");

        $this->assertEquals($parameters->getTitle(), "orginalBook");
    }
}
