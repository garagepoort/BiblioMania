<?php

class FirstPrintInfoParameterMapperTest extends TestCase {
    const TITLE = 'title';
    const SUBTITLE = 'subtitle';
    const ISBN = '1234567890232';
    const PUBLISHER = 'publisher';
    const COUNTRY = 'country';
    const DAY = 1;
    const MONTH = 12;
    const YEAR = 1991;
    const LANGUAGE = "lanaguage";

    /** @var  FirstPrintInfoParameterMapper */
    private $firstPrintInfoParameterMapper;
    /** @var  DateService */
    private $dateServiceMock;

    private $publicationDateMock;
    private $languageMock;

    public function setUp(){
        parent::setUp();
        $this->dateServiceMock = $this->mock('DateService');
        $this->firstPrintInfoParameterMapper = App::make('FirstPrintInfoParameterMapper');

        $this->publicationDateMock = Mockery::mock('Eloquent', 'Date');
        $this->languageMock = Mockery::mock('Eloquent', 'Language');
    }

    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('first_print_publication_date_day', null)->andReturn(self::DAY);
        $mockInput->shouldReceive('input')->with('first_print_publication_date_month', null)->andReturn(self::MONTH);
        $mockInput->shouldReceive('input')->with('first_print_publication_date_year', null)->andReturn(self::YEAR);

        $mockInput->shouldReceive('input')->with('first_print_title', null)->andReturn(self::TITLE);
        $mockInput->shouldReceive('input')->with('first_print_subtitle', null)->andReturn(self::SUBTITLE);
        $mockInput->shouldReceive('input')->with('first_print_isbn', null)->andReturn(self::ISBN);
        $mockInput->shouldReceive('input')->with('first_print_publisher', null)->andReturn(self::PUBLISHER);
        $mockInput->shouldReceive('input')->with('first_print_language', null)->andReturn(self::LANGUAGE);
        $mockInput->shouldReceive('input')->with('first_print_country', null)->andReturn(self::COUNTRY);
        Input::swap($mockInput);

        $this->dateServiceMock->shouldReceive('createDate')->once()->with(self::DAY, self::MONTH, self::YEAR)->andReturn($this->publicationDateMock);

        $firstPrintInfoParameters = $this->firstPrintInfoParameterMapper->create();

        $this->assertEquals(self::TITLE, $firstPrintInfoParameters->getTitle());
        $this->assertEquals(self::SUBTITLE, $firstPrintInfoParameters->getSubtitle());
        $this->assertEquals(self::ISBN, $firstPrintInfoParameters->getIsbn());
        $this->assertEquals(self::PUBLISHER, $firstPrintInfoParameters->getPublisher());
        $this->assertEquals(self::LANGUAGE, $firstPrintInfoParameters->getLanguage());
        $this->assertEquals(self::COUNTRY, $firstPrintInfoParameters->getCountry());
        $this->assertEquals($this->publicationDateMock, $firstPrintInfoParameters->getPublicationDate());
    }


}
