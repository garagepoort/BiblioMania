<?php

class BookControllerTest extends TestCase{

    private $bookFormValidatorMock;
    private $validatorMock;

    const NEW_NAME = "NEW_NAME";

    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  BookService */
    private $bookService;

    public function setUp(){
        parent::setUp();
        $this->bookCreationService = $this->mock('BookCreationService');
        $this->languageService = $this->mock('LanguageService');
        $this->bookFormValidatorMock = $this->mock('BookFormValidator');
        $this->bookService = $this->mock('BookService');

        $this->validatorMock = Mockery::mock('Illuminate\Validation\Factory');
        Validator::swap($this->validatorMock);
    }

    public function testGetFullBook_callsService(){
        $book_id =123;
        $book = new Book();
        $this->bookService->shouldReceive('getFullBook')->once()->with($book_id)->andReturn($book);

        $parameters = array(
            'book_id'=>$book_id
        );
        $response = $this->action('GET', 'BookController@getFullBook', null, $parameters);
    }
}
