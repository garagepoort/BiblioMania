<?php

class FileToFirstPrintParametersMapperTest extends TestCase {
    /** @var  FileToFirstPrintParametersMapper */
    private $fileToFirstPrintParametersMapper;
    /** @var DateImporter */
    private $dateImporter;
    /** @var Date */
    private $dateMock;

    public function setUp(){
        parent::setUp();
        $this->dateImporter = $this->mock('DateImporter');
        $this->fileToFirstPrintParametersMapper = App::make('FileToFirstPrintParametersMapper');

        $this->dateMock = Mockery::mock('Eloquent', 'Date');
    }

    public function test_map_mapsCorrect(){
        $this->dateImporter->shouldReceive('getPublicationDate')->once()->with("publicationDate")->andReturn($this->dateMock);

        $line_values = [50];
        $line_values[LineMapping::FirstPrintTitle] = "title";
        $line_values[LineMapping::FirstAuthorFirstName] = "authorFirstname";
        $line_values[LineMapping::FirstAuthorName] = "authorName";
        $line_values[LineMapping::FirstAuthorInfix] = "infix";
        $line_values[LineMapping::FirstPrintCountry] = "someCountry";
        $line_values[LineMapping::FirstPrintLanguage] = "lang";
        $line_values[LineMapping::FirstPrintPublicationDate] = "publicationDate";
        $line_values[LineMapping::FirstPrintPublisherName] = "publisher";

        $parameters = $this->fileToFirstPrintParametersMapper->map($line_values, "orginalBook");

        $expectedLanguage = new Language();
        $expectedLanguage->name = "lang";

        $this->assertEquals($parameters->getTitle(), "title");
        $this->assertEquals($parameters->getSubtitle(), "");
        $this->assertEquals($parameters->getIsbn(), "");
        $this->assertEquals($parameters->getCountry(), "someCountry");
        $this->assertEquals($parameters->getPublisher(), "publisher");
        $this->assertEquals($parameters->getLanguage(), $expectedLanguage);
        $this->assertEquals($parameters->getPublicationDate(), $this->dateMock);
    }

    public function test_map_whenTitleNotFilledIn_orginalBookTitleIsUsed(){
        $this->dateImporter->shouldReceive('getPublicationDate')->once()->with("publicationDate")->andReturn($this->dateMock);

        $line_values = [50];
        $line_values[LineMapping::FirstPrintTitle] = "";
        $line_values[LineMapping::FirstAuthorFirstName] = "authorFirstname";
        $line_values[LineMapping::FirstAuthorName] = "authorName";
        $line_values[LineMapping::FirstAuthorInfix] = "infix";
        $line_values[LineMapping::FirstPrintCountry] = "someCountry";
        $line_values[LineMapping::FirstPrintLanguage] = "lang";
        $line_values[LineMapping::FirstPrintPublicationDate] = "publicationDate";
        $line_values[LineMapping::FirstPrintPublisherName] = "publisher";

        $parameters = $this->fileToFirstPrintParametersMapper->map($line_values, "orginalBook");

        $expectedLanguage = new Language();
        $expectedLanguage->name = "lang";

        $this->assertEquals($parameters->getTitle(), "orginalBook");
        $this->assertEquals($parameters->getSubtitle(), "");
        $this->assertEquals($parameters->getIsbn(), "");
        $this->assertEquals($parameters->getCountry(), "someCountry");
        $this->assertEquals($parameters->getPublisher(), "publisher");
        $this->assertEquals($parameters->getLanguage(), $expectedLanguage);
        $this->assertEquals($parameters->getPublicationDate(), $this->dateMock);
    }
}
