<?php

class FileToExtraBookInfoParametersMapperTest extends TestCase {
    /** @var  FileToExtraBookInfoParametersMapper */
    private $fileToExtraBookInfoParametersMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToExtraBookInfoParametersMapper = App::make('FileToExtraBookInfoParametersMapper');
    }

    public function test_map_worksCorrect(){
        $line_values = [70];

        $line_values[LineMapping::$ExtraBookInfoPrint] = "12";
        $line_values[LineMapping::$ExtraBookInfoPages] = "1032";
        $line_values[LineMapping::$ExtraBookInfoTranslator] = "translator";
        $line_values[LineMapping::$BookSummary] = "someSummary";
        $line_values[LineMapping::$BookState] = "state";
        $line_values[LineMapping::$ExtraBookInfoTags] = "tags";

        /** @var ExtraBookInfoParameters $parameters */
        $parameters = $this->fileToExtraBookInfoParametersMapper->map($line_values);

        $this->assertEquals("12", $parameters->getPrint());
        $this->assertEquals("1032", $parameters->getPages());
        $this->assertEquals("someSummary", $parameters->getSummary());
        $this->assertEquals("translator", $parameters->getTranslator());
        $this->assertEquals("state", $parameters->getState());
        $this->assertEquals("tags", $parameters->getOldTags());
    }
}
