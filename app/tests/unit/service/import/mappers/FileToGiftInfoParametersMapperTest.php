<?php

class FileToGiftInfoParametersMapperTest extends TestCase {

    /** @var  FileToGiftInfoParametersMapperTest */
    private $fileToGiftInfoParametersMapperTest;

    public function setUp(){
        parent::setUp();
        $this->fileToGiftInfoParametersMapperTest = App::make('FileToGiftInfoParametersMapper');
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::GiftInfoDate] = "12-03-14";
        $line_values[LineMapping::GiftInfoFrom] = "fromSome";

        $expectedDate = DateTime::createFromFormat('d-m-y', "12-03-14");

        /** @var GiftInfoParameters $parameters */
        $parameters = $this->fileToGiftInfoParametersMapperTest->map($line_values);

        $this->assertEquals($expectedDate, $parameters->getDate());
        $this->assertEquals("fromSome", $parameters->getFrom());
    }
}
