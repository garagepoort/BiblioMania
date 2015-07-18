<?php

class BookInfoParameterMapperTest extends TestCase {
    const BOOK_ID = 234;
    const TITLE = 'title';
    const SUBTITLE = 'subtitle';
    const ISBN = '1234567890123';
    const GENRE = 'genre';
    const PUBLISHER = 'publisher';
    const COUNTRY = 'country';
    const LANGUAGE = "LANGUAGE";
    const PUBLICATION_DAY = 21;
    const PUBLICATION_MONTH = 12;
    const PUBLICATION_YEAR = 1991;
    const BUY = 'BUY';
    const RETAIL_PRICE = 123;
    const GIFT = 'GIFT';
    const TAGS = 'TAGS;TAGS2';

    /** @var  BookInfoParameterMapper */
    private $bookInfoParameterMapper;
    /** @var  DateService */
    private $dateServiceMock;
    /** @var  Date */
    private $publicationDateMock;

    public function setUp(){
        parent::setUp();
        $this->dateServiceMock = $this->mock('DateService');
        $this->languageService = $this->mock('LanguageService');
        $this->bookInfoParameterMapper = App::make('BookInfoParameterMapper');

        $this->publicationDateMock = Mockery::mock('Eloquent', 'Date');
        $this->languageMock = Mockery::mock('Eloquent', 'Language');
    }

    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');

        $mockInput->shouldReceive('input')->with('book_id', null)->andReturn(self::BOOK_ID);
        $mockInput->shouldReceive('input')->with('book_publication_date_day', null)->andReturn(self::PUBLICATION_DAY);
        $mockInput->shouldReceive('input')->with('book_publication_date_month', null)->andReturn(self::PUBLICATION_MONTH);
        $mockInput->shouldReceive('input')->with('book_publication_date_year', null)->andReturn(self::PUBLICATION_YEAR);
        $this->dateServiceMock->shouldReceive('createDate')->once()->with(self::PUBLICATION_DAY, self::PUBLICATION_MONTH, self::PUBLICATION_YEAR)->andReturn($this->publicationDateMock);

        $mockInput->shouldReceive('input')->with('buyOrGift', null)->andReturn(self::BUY);
        $mockInput->shouldReceive('input')->with('buy_book_info_retail_price', null)->andReturn(self::RETAIL_PRICE);
        $mockInput->shouldReceive('input')->with('book_title', null)->andReturn(self::TITLE);
        $mockInput->shouldReceive('input')->with('book_subtitle', null)->andReturn(self::SUBTITLE);
        $mockInput->shouldReceive('input')->with('book_isbn', null)->andReturn(self::ISBN);
        $mockInput->shouldReceive('input')->with('book_genre', null)->andReturn(self::GENRE);
        $mockInput->shouldReceive('input')->with('book_publisher', null)->andReturn(self::PUBLISHER);
        $mockInput->shouldReceive('input')->with('book_country', null)->andReturn(self::COUNTRY);
        $mockInput->shouldReceive('input')->with('book_language', null)->andReturn(self::LANGUAGE);
        $mockInput->shouldReceive('input')->with('book_tags', null)->andReturn(self::TAGS);
        Input::swap($mockInput);

        $bookInfoParameters = $this->bookInfoParameterMapper->create();

        $this->assertEquals(self::BOOK_ID, $bookInfoParameters->getBookId());
        $this->assertEquals(self::TITLE, $bookInfoParameters->getTitle());
        $this->assertEquals(self::SUBTITLE, $bookInfoParameters->getSubtitle());
        $this->assertEquals(self::ISBN, $bookInfoParameters->getIsbn());
        $this->assertEquals(self::GENRE, $bookInfoParameters->getGenre());
        $this->assertEquals(self::PUBLISHER, $bookInfoParameters->getPublisherName());
        $this->assertEquals(self::COUNTRY, $bookInfoParameters->getCountryName());
        $this->assertEquals(self::LANGUAGE, $bookInfoParameters->getLanguage());
        $this->assertEquals(self::RETAIL_PRICE, $bookInfoParameters->getRetailPrice());
        $this->assertEquals(array("TAGS", "TAGS2"), $bookInfoParameters->getTags());
        $this->assertEquals($this->publicationDateMock, $bookInfoParameters->getPublicationDate());
    }

    public function testCreate_whenGIFT_getsRetailPriceFromGift(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');

        $mockInput->shouldReceive('input')->with('book_id', null)->andReturn(self::BOOK_ID);
        $mockInput->shouldReceive('input')->with('book_publication_date_day', null)->andReturn(self::PUBLICATION_DAY);
        $mockInput->shouldReceive('input')->with('book_publication_date_month', null)->andReturn(self::PUBLICATION_MONTH);
        $mockInput->shouldReceive('input')->with('book_publication_date_year', null)->andReturn(self::PUBLICATION_YEAR);
        $this->dateServiceMock->shouldReceive('createDate')->once()->with(self::PUBLICATION_DAY, self::PUBLICATION_MONTH, self::PUBLICATION_YEAR)->andReturn($this->publicationDateMock);
        $mockInput->shouldReceive('input')->with('buyOrGift', null)->andReturn(self::GIFT);
        $mockInput->shouldReceive('input')->with('book_title', null)->andReturn(self::TITLE);
        $mockInput->shouldReceive('input')->with('book_subtitle', null)->andReturn(self::SUBTITLE);
        $mockInput->shouldReceive('input')->with('book_isbn', null)->andReturn(self::ISBN);
        $mockInput->shouldReceive('input')->with('book_genre', null)->andReturn(self::GENRE);
        $mockInput->shouldReceive('input')->with('book_publisher', null)->andReturn(self::PUBLISHER);
        $mockInput->shouldReceive('input')->with('book_country', null)->andReturn(self::COUNTRY);
        $mockInput->shouldReceive('input')->with('book_language', null)->andReturn(self::LANGUAGE);
        $mockInput->shouldReceive('input')->with('book_tags', null)->andReturn(self::TAGS);

        $mockInput->shouldReceive('input')->with('gift_book_info_retail_price', null)->andReturn(765);
        Input::swap($mockInput);

        $bookInfoParameters = $this->bookInfoParameterMapper->create();

        $this->assertEquals(765, $bookInfoParameters->getRetailPrice());
    }
}
