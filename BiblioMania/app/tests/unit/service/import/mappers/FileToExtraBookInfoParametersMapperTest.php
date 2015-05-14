<?php

class FileToExtraBookInfoParametersMapperTest extends TestCase {
    /** @var  FileToExtraBookInfoParametersMapper */
    private $fileToExtraBookInfoParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToExtraBookInfoParametersMapper = App::make('FileToExtraBookInfoParametersMapper');
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::ExtraBookInfoPrint] = "12";
        $line_values[LineMapping::ExtraBookInfoPages] = "1032";

        /** @var ExtraBookInfoParameters $parameters */
        $parameters = $this->fileToExtraBookInfoParametersMapper->map($line_values);

        $this->assertEquals("12", $parameters->getPrint());
        $this->assertEquals("1032", $parameters->getPages());
    }
}
