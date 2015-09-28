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
        $parameters = array(
            'book_id'=>'1',
            'scroll_id'=>'23'
        );

        $response = $this->action('GET', 'BookController@getBooks', null, $parameters);

        $this->assertViewHas('title', 'Boeken');
    }
}
