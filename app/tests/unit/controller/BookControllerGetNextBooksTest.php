<?php

class BookControllerGetNextBooksTest extends TestCase
{
    const ORDER_BY = "order_by";
    const BOOK_ID = "book id";

    /** @var  BookService */
    private $bookService;
    /** @var  Book */
    private $book;

    private $filteredResults;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->book = $this->mockEloquent('Book');
    }

    public function test_getsFilteredBooksFromService(){
        $this->bookService->shouldReceive('getFilteredBooks')->with(self::BOOK_ID, any("BookFilterValues"), self::ORDER_BY)
                ->once()
                ->andReturn($this->filteredResults);

        $parameters = array(
            'book_id'=>self::BOOK_ID,
            'order_by'=>self::ORDER_BY,
        );

        $response = $this->action('GET', 'BookController@getNextBooks', null, $parameters);

        $this->assertEquals($response->original, $this->filteredResults);
    }
}
