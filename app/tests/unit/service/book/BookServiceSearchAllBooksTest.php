<?php

class BookServiceSearchAllBooksTest extends TestCase
{

    /** @var BookService $bookService */
    private $bookService;


    public function setUp(){
        parent::setUp();
        $this->bookService = App::make('BookService');
    }

    public function test_callsIndexerWithCorrectFiltersAndReturnsBooks(){
        $filters = array();
//        $this->bookService->searchAllBooks();
    }
    


}
