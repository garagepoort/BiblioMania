<?php

class BookControllerGetBooksFromSearchTest extends TestCase{

    const NEW_NAME = "NEW_NAME";
    const CRITERIA = 'criteria';

    private $bookService;
    private $books;


    const VALUE_OF_LIBRARY = 2400;

    const TOTAL_AMOUNT_BOOKS_IN_LIBRARY = 500;

    const TOTAL_AMOUNT_BOOKS_OWNED = 300;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
        $this->books = array($this->createFakeBook());
    }

    public function test_returnsCorrectView_withBoundVariables(){
        $this->markTestSkipped(
            'The MySQLi extension is not available.'
        );
        $this->bookService->shouldReceive('searchBooks')->once()->with(self::CRITERIA)->andReturn($this->books);
        $this->bookService->shouldReceive('getValueOfLibrary')->once()->andReturn(self::VALUE_OF_LIBRARY);
        $this->bookService->shouldReceive('getTotalAmountOfBooksInLibrary')->once()->andReturn(self::TOTAL_AMOUNT_BOOKS_IN_LIBRARY);
        $this->bookService->shouldReceive('getTotalAmountOfBooksOwned')->once()->andReturn(self::TOTAL_AMOUNT_BOOKS_OWNED);

        $parameters = array(
            'criteria'=> self::CRITERIA
        );

        $response = $this->action('GET', 'BookController@getBooksFromSearch', null, $parameters);

        $this->assertViewHas('title', 'Boeken');
        $this->assertViewHas('books', $this->books);
        $this->assertViewHas('total_value_library', self::VALUE_OF_LIBRARY);
        $this->assertViewHas('total_amount_of_books', self::TOTAL_AMOUNT_BOOKS_IN_LIBRARY);
        $this->assertViewHas('total_amount_of_books_owned', self::TOTAL_AMOUNT_BOOKS_OWNED);
        $this->assertViewHas('bookFilters', BookFilter::getFilters());
    }
}
