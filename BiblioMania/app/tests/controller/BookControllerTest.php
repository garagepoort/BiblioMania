<?php

class BookControllerTest extends TestCase{

    private $countryServiceMock;
    private $bookFormValidatorMock;
    private $validatorMock;
    private $publisherServiceMock;
    private $buyInfoService;
    private $giftInfoService;
    private $bookService;
    private $dateService;
    private $imageService;

    const NEW_NAME = "NEW_NAME";

    public function setUp(){
        parent::setUp();
        $this->countryServiceMock = $this->mock('CountryService');
        $this->bookFormValidatorMock = $this->mock('BookFormValidator');
        $this->publisherServiceMock = $this->mock('PublisherService');

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

    public function testCreateOrEditBook_whenValidationSuccess_findOrCreateCountry(){
        $this->validatorMock->shouldReceive('fails')->once()->andReturn(false);
        $bookCountry = Mockery::mock('Eloquent', 'Country');
        $bookPublisher = Mockery::mock('Eloquent', 'Publisher');
        $this->countryServiceMock->shouldReceive('findOrCreate')->once()->with('someCountry')->andReturn($bookCountry);
        $this->publisherServiceMock->shouldReceive('saveOrUpdate')->once()->with('somePublisher', $bookCountry)->andReturn($bookPublisher);

        $parameters = array(
            'book_id'=>'123',
            'book_country'=>'someCountry',
            'book_publisher'=>'somePublisher'
        );
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