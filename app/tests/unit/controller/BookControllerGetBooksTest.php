<?php

class BookControllerGetBooksTest extends TestCase{

    const NEW_NAME = "NEW_NAME";

    private $bookService;

    public function setUp(){
        parent::setUp();
        $this->bookService = $this->mock('BookService');
    }

    public function test_returnsCorrectView_withBoundVariables(){
        $orderByValues = array('author' => 'Auteur', 'title' => 'Titel', 'subtitle' => 'Ondertitel', 'rating' => 'Waardering');
        $this->bookService->shouldReceive('getOrderByValues')->once()->andReturn($orderByValues);
        $this->bookService->shouldReceive('getValueOfLibrary')->once()->andReturn(2400);
        $this->bookService->shouldReceive('getTotalAmountOfBooksInLibrary')->once()->andReturn(500);
        $this->bookService->shouldReceive('getTotalAmountOfBooksOwned')->once()->andReturn(300);
        $parameters = array(
            'book_id'=>'1',
            'scroll_id'=>'23'
        );

        $response = $this->action('GET', 'BookController@getBooks', null, $parameters);

        $this->assertViewHas('title', 'Boeken');
    }
}
