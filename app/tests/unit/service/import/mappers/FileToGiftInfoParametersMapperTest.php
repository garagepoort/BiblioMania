<?php

class FileToGiftInfoParametersMapperTest extends TestCase {

    /** @var  FileToGiftInfoParametersMapper */
    private $fileToGiftInfoParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToGiftInfoParametersMapper = App::make('FileToGiftInfoParametersMapper');

        $values = array(
            "Aanschafdatum",
            "Gekregen van:");
        LineMapping::initializeMapping($values);
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::$GiftInfoDate] = "12/03/14";
        $line_values[LineMapping::$GiftInfoFrom] = "fromSome";

        $expectedDate = DateTime::createFromFormat('d/m/Y', "12/03/14");

        /** @var GiftInfoParameters $parameters */
        $parameters = $this->fileToGiftInfoParametersMapper->map($line_values);

        $this->assertEquals($expectedDate, $parameters->getDate());
        $this->assertEquals("fromSome", $parameters->getFrom());
    }
}
