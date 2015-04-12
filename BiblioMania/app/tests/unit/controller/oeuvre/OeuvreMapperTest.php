<?php

class OeuvreMapperTest extends TestCase
{
    /** @var  OeuvreMapper */
    private $oeuvreMapper;


    public function setUp(){
        parent::setUp();
        $this->oeuvreMapper = App::make('OeuvreMapper');
    }

    public function testMap_mapsCorrect()
    {
        $author_id = 123456;

        $text = "1234 - some booki\n"
            . "4321 - another book\n"
            . "1991 - last book";

        $oeuvreList = $this->oeuvreMapper->mapToOeuvreList($text, $author_id);

        $this->assertEquals(count($oeuvreList), 3);
        $this->assertEquals($oeuvreList[0]->publication_year, 1234);
        $this->assertEquals($oeuvreList[0]->title, "some booki");
        $this->assertEquals($oeuvreList[0]->author_id, $author_id);

        $this->assertEquals($oeuvreList[1]->publication_year, 4321);
        $this->assertEquals($oeuvreList[1]->title, "another book");
        $this->assertEquals($oeuvreList[1]->author_id, $author_id);

        $this->assertEquals($oeuvreList[2]->publication_year, 1991);
        $this->assertEquals($oeuvreList[2]->title, "last book");
        $this->assertEquals($oeuvreList[2]->author_id, $author_id);
    }
}
