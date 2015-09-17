<?php

class AuthorInfoParameterMapperTest extends TestCase {
    const NAME = 'name';
    const FIRSTNAME = 'firstname';
    const INFIX = 'infix';
    const DAY_BIRTH = 6;
    const MONTH_BIRTH = 2;
    const YEAR_BIRTH = 1991;
    const DAY_DEATH = 8;
    const MONTH_DEATH = 3;
    const YEAR_DEATH = 2023;
    const SELF_UPLOAD = true;
    const BOOK_FROM_AUTHOR = 'bookFromAuthor';
    const IMAGE = 'image';
    const OEUVRE = 'SOME OEUVRE';

    private $bookFromAuthorParameters;

    /** @var  AuthorInfoParameterMapper */
    private $authorInfoParameterMapper;
    /** @var  DateService */
    private $dateServiceMock;
    /** @var  OeuvreToParameterMapper */
    private $oeuvreToParameterMapper;

    private $birthDateMock;
    private $deathDateMock;
    private $mockInput;

    public function setUp(){
        parent::setUp();
        $this->dateServiceMock = $this->mock('DateService');
        $this->oeuvreToParameterMapper = $this->mock('OeuvreToParameterMapper');
        $this->authorInfoParameterMapper = App::make('AuthorInfoParameterMapper');

        $this->mockInput = Mockery::mock('\Illuminate\Http\Request');

        $this->birthDateMock = Mockery::mock('Eloquent', 'Date');
        $this->deathDateMock = Mockery::mock('Eloquent', 'Date');
    }

    public function testCreate_mapsCorrect(){
        $this->mockDates($this->mockInput);
        $this->mockOther($this->mockInput);
        $this->mockInput->shouldReceive('input')->with('authorImageSelfUpload', null)->andReturn(self::SELF_UPLOAD);
        $this->mockInput->shouldReceive('input')->with('bookFromAuthorTitle', null)->andReturn(self::BOOK_FROM_AUTHOR);
        $this->mockInput->shouldReceive('file')->with('author_image')->andReturn(self::IMAGE);
        $this->mockInput->shouldReceive('hasFile')->with('author_image')->andReturn(true);
        Input::swap($this->mockInput);


        $authorInfoParameters = $this->authorInfoParameterMapper->create();

        $this->assertEquals(self::NAME, $authorInfoParameters->getName());
        $this->assertEquals(self::FIRSTNAME, $authorInfoParameters->getFirstname());
        $this->assertEquals(self::INFIX, $authorInfoParameters->getInfix());
        $this->assertEquals($this->birthDateMock, $authorInfoParameters->getDateOfBirth());
        $this->assertEquals($this->deathDateMock, $authorInfoParameters->getDateOfDeath());
        $this->assertEquals(self::IMAGE, $authorInfoParameters->getImage());
        $this->assertEquals(self::BOOK_FROM_AUTHOR, $authorInfoParameters->getLinkedBook());
        $this->assertEquals($this->bookFromAuthorParameters, $authorInfoParameters->getOeuvre());
        $this->assertEquals(ImageSaveType::UPLOAD, $authorInfoParameters->getImageSaveType());
    }

    public function testWhenSelfUpload_getsImageFromInput(){
        //SETUP
        $this->mockDates($this->mockInput);
        $this->mockOther($this->mockInput);
        $this->mockInput->shouldReceive('input')->with('bookFromAuthorTitle', null)->andReturn(self::BOOK_FROM_AUTHOR);

        $this->mockInput->shouldReceive('input')->with('authorImageSelfUpload', null)->andReturn(false);
        $this->mockInput->shouldReceive('input')->with('authorImageUrl', null)->andReturn(self::IMAGE);
        Input::swap($this->mockInput);

        $authorInfoParameters = $this->authorInfoParameterMapper->create();

        $this->assertEquals(self::IMAGE, $authorInfoParameters->getImage());
        $this->assertEquals(ImageSaveType::URL, $authorInfoParameters->getImageSaveType());
    }

    public function testWhenNotSelfUpload_imageIsUrl(){
        //SETUP
        $this->mockDates($this->mockInput);
        $this->mockOther($this->mockInput);
        $this->mockInput->shouldReceive('input')->with('bookFromAuthorTitle', null)->andReturn(self::BOOK_FROM_AUTHOR);

        $this->mockInput->shouldReceive('input')->with('authorImageSelfUpload', null)->andReturn(false);
        $this->mockInput->shouldReceive('input')->with('authorImageUrl', null)->andReturn('someURL');
        Input::swap($this->mockInput);

        $authorInfoParameters = $this->authorInfoParameterMapper->create();

        $this->assertEquals('someURL', $authorInfoParameters->getImage());
        $this->assertEquals(ImageSaveType::URL, $authorInfoParameters->getImageSaveType());
    }


    public function testWhenNotSelfUpload_andIfUrlNotFilledIn_ImageIsNull(){
        //SETUP
        $this->mockDates($this->mockInput);
        $this->mockOther($this->mockInput);
        $this->mockInput->shouldReceive('input')->with('bookFromAuthorTitle', null)->andReturn(self::BOOK_FROM_AUTHOR);

        $this->mockInput->shouldReceive('input')->with('authorImageSelfUpload', null)->andReturn(false);
        $this->mockInput->shouldReceive('input')->with('authorImageUrl', null)->andReturn('');
        Input::swap($this->mockInput);

        $authorInfoParameters = $this->authorInfoParameterMapper->create();

        $this->assertEquals(null, $authorInfoParameters->getImage());
    }

    private function mockDates($mockInput)
    {
        $this->dateServiceMock->shouldReceive('createDate')->once()->with(self::DAY_BIRTH, self::MONTH_BIRTH, self::YEAR_BIRTH)->andReturn($this->birthDateMock);
        $this->dateServiceMock->shouldReceive('createDate')->once()->with(self::DAY_DEATH, self::MONTH_DEATH, self::YEAR_DEATH)->andReturn($this->deathDateMock);

        $mockInput->shouldReceive('input')->with('author_date_of_birth_day', null)->andReturn(self::DAY_BIRTH);
        $mockInput->shouldReceive('input')->with('author_date_of_birth_month', null)->andReturn(self::MONTH_BIRTH);
        $mockInput->shouldReceive('input')->with('author_date_of_birth_year', null)->andReturn(self::YEAR_BIRTH);
        $mockInput->shouldReceive('input')->with('author_date_of_death_day', null)->andReturn(self::DAY_DEATH);
        $mockInput->shouldReceive('input')->with('author_date_of_death_month', null)->andReturn(self::MONTH_DEATH);
        $mockInput->shouldReceive('input')->with('author_date_of_death_year', null)->andReturn(self::YEAR_DEATH);
    }

    private function mockOther($mockInput)
    {
        $mockInput->shouldReceive('input')->with('author_name', null)->andReturn(self::NAME);
        $mockInput->shouldReceive('input')->with('author_firstname', null)->andReturn(self::FIRSTNAME);
        $mockInput->shouldReceive('input')->with('author_infix', null)->andReturn(self::INFIX);
        $mockInput->shouldReceive('input')->with('oeuvre', null)->andReturn(self::OEUVRE);

        $this->bookFromAuthorParameters = array(new BookFromAuthorParameters('some Title', 1234));
        $this->oeuvreToParameterMapper->shouldReceive('mapToOeuvreList')->with(self::OEUVRE)->andReturn($this->bookFromAuthorParameters);
    }
}
