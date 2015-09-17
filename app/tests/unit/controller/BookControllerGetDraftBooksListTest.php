<?php

class BookControllerGetBooksListTest extends TestCase{

    const NEW_NAME = "NEW_NAME";
    const PUBLISHER_NAME = "publisher name";

    private $bookService;
    private $books;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->books = array($this->createFakeBook());
    }

    public function test_returnsCorrectView_withBoundVariables(){
        $this->bookService->shouldReceive("getDraftBooksForList")
            ->once()
            ->andReturn($this->books);

        $parameters = array();

        $this->action('GET', 'BookController@getDraftBooksList', null, $parameters);

        $this->assertViewHas('title', 'Boeken');
        $this->assertViewHas('books', $this->books);
    }
}
