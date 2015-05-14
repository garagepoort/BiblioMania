<?php

class FileToOeuvreParametersMapperTest extends TestCase {

    /** @var  FileToOeuvreParametersMapper */
    private $fileToOeuvreMapper;

    public function setUp(){
        parent::setUp();
        $this->fileToOeuvreMapper = App::make('FileToOeuvreParametersMapper');
    }

    public function testMapOeuvre_mapsCorrect(){
        $oeuvre = '* Understanding Organisations (1983)\n ' .
            '* The Future of Work (1984)\n '.
            '* Gods of Management (1985) \n '.
            '* The Elephant and the Flea (2001)\n';

        $bookFromAuthors = $this->fileToOeuvreMapper->map($oeuvre);

        $this->assertEquals(4,count($bookFromAuthors));
        $this->assertEquals("Understanding Organisations", $bookFromAuthors[0]->getTitle());
        $this->assertEquals(1983, $bookFromAuthors[0]->getYear());

        $this->assertEquals("The Future of Work", $bookFromAuthors[1]->getTitle());
        $this->assertEquals(1984, $bookFromAuthors[1]->getYear());

        $this->assertEquals("Gods of Management", $bookFromAuthors[2]->getTitle());
        $this->assertEquals(1985, $bookFromAuthors[2]->getYear());

        $this->assertEquals("The Elephant and the Flea", $bookFromAuthors[3]->getTitle());
        $this->assertEquals(2001, $bookFromAuthors[3]->getYear());
    }
}
