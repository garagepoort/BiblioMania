<?php

class BookControllerGetFullBookTest extends TestCase{

    private $bookService;
    const BOOK_ID = "book id";
    /** @var  Book */
    private $book;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->book = $this->mockEloquent('Book');
    }

    public function test_getsBookFromService(){
        $this->bookService->shouldReceive('getFullBook')->with(self::BOOK_ID)->once()->andReturn($this->book);
        $parameters = array(
            'book_id'=>self::BOOK_ID,
        );

        $response = $this->action('GET', 'BookController@getFullBook', null, $parameters);

        $this->assertEquals($response->original, $this->book);
    }
}
