<?php

class OeuvreServiceTest extends TestCase {

    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  BookFromAuthorRepository */
    private $bookFromAuthorRepository;

    public function setUp(){
        parent::setUp();
        $this->bookFromAuthorRepository = $this->mock("BookFromAuthorRepository");
        $this->oeuvreService = App::make("OeuvreService");
    }

    public function test_saveBookFromAuthors_savesCorrect(){
        $bookFromAuthors = array();
        $author_id = 123;
        $bookFromAuthor1 = new BookFromAuthor();
        $bookFromAuthor2 = new BookFromAuthor();
        array_push($bookFromAuthors, $bookFromAuthor1);
        array_push($bookFromAuthors, $bookFromAuthor2);

        $this->bookFromAuthorRepository->shouldReceive("save")->once()->with($bookFromAuthor1);
        $this->bookFromAuthorRepository->shouldReceive("save")->once()->with($bookFromAuthor2);

        $this->oeuvreService->saveBookFromAuthors($bookFromAuthors, $author_id);

        $this->assertEquals($bookFromAuthor1->author_id, $author_id);
        $this->assertEquals($bookFromAuthor2->author_id, $author_id);

    }
}
