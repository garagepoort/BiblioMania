<?php

class OeuvreToParameterMapperTest extends TestCase
{
    /** @var  OeuvreToParameterMapper */
    private $oeuvreMapper;


    public function setUp(){
        parent::setUp();
        $this->oeuvreMapper = App::make('OeuvreToParameterMapper');
    }

    public function testMap_mapsCorrect()
    {
        $author_id = 123456;

        $text = "1234 - some booki\n"
            . "4321 - another book\n"
            . "1991 - last book";

        $oeuvreList = $this->oeuvreMapper->mapToOeuvreList($text, $author_id);

        $this->assertEquals(count($oeuvreList), 3);
        $this->assertEquals($oeuvreList[0]->getYear(), 1234);
        $this->assertEquals($oeuvreList[0]->getTitle(), "some booki");

        $this->assertEquals($oeuvreList[1]->getYear(), 4321);
        $this->assertEquals($oeuvreList[1]->getTitle(), "another book");

        $this->assertEquals($oeuvreList[2]->getYear(), 1991);
        $this->assertEquals($oeuvreList[2]->getTitle(), "last book");
    }
}
