<?php

class FileToPersonalBookInfoParametersMapperTest extends TestCase {
    /** @var  FileToPersonalBookInfoParametersMapper */
    private $fileToPersonalBookInfoParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToPersonalBookInfoParametersMapper = App::make('FileToPersonalBookInfoParametersMapper');
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::PersonalBookInfoRating] = "12";
        $line_values[LineMapping::PersonalBookInfoReadingDate] = "12-03-14";
        $line_values[LineMapping::PersonalBookInfoInCollection] = "In verzameling";

        $expectedDate = DateTime::createFromFormat('d-m-y', "12-03-14");

        /** @var PersonalBookInfoParameters $parameters */
        $parameters = $this->fileToPersonalBookInfoParametersMapper->map($line_values);

        $this->assertEquals($expectedDate, $parameters->getReadingDates()[0]);
        $this->assertEquals("12", $parameters->getRating());
        $this->assertEquals(true, $parameters->getOwned());
    }
}
