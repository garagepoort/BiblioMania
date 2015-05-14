<?php

class BookControllerTest extends TestCase{

    private $bookFormValidatorMock;
    private $validatorMock;

    const NEW_NAME = "NEW_NAME";

    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  LanguageService */
    private $languageService;

    public function setUp(){
        parent::setUp();
        $this->bookCreationService = $this->mock('BookCreationService');
        $this->languageService = $this->mock('LanguageService');
        $this->bookFormValidatorMock = $this->mock('BookFormValidator');

        $this->validatorMock = Mockery::mock('Illuminate\Validation\Factory');
        Validator::swap($this->validatorMock);
        $this->bookFormValidatorMock->shouldReceive('createValidator')->once()->andReturn($this->validatorMock);
    }

    public function testCreateOrEditBook_whenValidationFailsAndBookIdEmpty_returnToCreateBookPageWithErrors(){
        $this->validatorMock->shouldReceive('fails')->once()->andReturn(true);

        $parameters = array(
            'book_id'=>''
        );
        $response = $this->action('POST', 'BookController@createOrEditBook', null, $parameters);

        $this->assertRedirectedTo('/createBook');
    }

    public function testCreateOrEditBook_whenValidationFailsAndBookIdNotEmpty_returnToEditBookPageWithErrors(){
        $this->validatorMock->shouldReceive('fails')->once()->andReturn(true);

        $parameters = array(
            'book_id'=>'123'
        );
        $response = $this->action('POST', 'BookController@createOrEditBook', null, $parameters);
        $this->assertRedirectedTo('/editBook/123');
    }

    public function testCreateOrEditBook_whenValidationSuccess_callBookCreationService(){
        $this->validatorMock->shouldReceive('fails')->once()->andReturn(false);

        $this->bookCreationService->shouldReceive("createBook")->once();

        $parameters = array(
            'book_id'=>'123',
            'book_country'=>'someCountry',
            'book_publisher'=>'somePublisher',
            'book_languageId'=>'12',
            'first_print_languageId'=>'122'
        );

        $langBook = $this->mockEloquent('Language');
        $langFirstPrint = $this->mockEloquent('Language');
        $this->languageService->shouldReceive('find')->once()->with('12')->andReturn($langBook);
        $this->languageService->shouldReceive('find')->once()->with('122')->andReturn($langFirstPrint);

        $response = $this->action('POST', 'BookController@createOrEditBook', null, $parameters);

        $this->assertRedirectedTo('/getBooks');
    }

//    public function testCreateOrEditBookController_callsCorrectServices(){
//        $parameters = array(
//            'book_id'=>'admin',
//            'password'=>'admin',
//            'csrf_token' => csrf_token()
//        );
//
//        $response = $this->action('POST', 'BookController@createOrEditBook', null, $parameters);
//
//        $this->call('GET', '/');
//    }
}