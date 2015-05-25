<?php

class ExtraBookInfoParameterMapperTest extends TestCase {

    const PAGES = 43;
    const PRINT_NUMBER = 23;
    const BOOK_SERIE = 'book serie';
    const PUBLISHER_SERIE = 'publisher serie';
    const TRANSLATOR = 'translator';
    const SUMMARY = 'summary';

    /** @var  ExtraBookInfoParameterMapper */
    private $extraBookInfoParameterMapper;

    public function setUp(){
        parent::setUp();
        $this->extraBookInfoParameterMapper = App::make('ExtraBookInfoParameterMapper');
    }


    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('book_number_of_pages', null)->andReturn(self::PAGES);
        $mockInput->shouldReceive('input')->with('book_print', null)->andReturn(self::PRINT_NUMBER);
        $mockInput->shouldReceive('input')->with('translator', null)->andReturn(self::TRANSLATOR);
        $mockInput->shouldReceive('input')->with('book_summary', null)->andReturn(self::SUMMARY);
        $mockInput->shouldReceive('input')->with('book_serie', null)->andReturn(self::BOOK_SERIE);
        $mockInput->shouldReceive('input')->with('book_publisher_serie', null)->andReturn(self::PUBLISHER_SERIE);
        Input::swap($mockInput);

        $extraBookInfoParameters = $this->extraBookInfoParameterMapper->create();

        $this->assertEquals(self::PAGES, $extraBookInfoParameters->getPages());
        $this->assertEquals(self::PRINT_NUMBER, $extraBookInfoParameters->getPrint());
        $this->assertEquals(self::BOOK_SERIE, $extraBookInfoParameters->getBookSerie());
        $this->assertEquals(self::PUBLISHER_SERIE, $extraBookInfoParameters->getPublisherSerie());
        $this->assertEquals(self::TRANSLATOR, $extraBookInfoParameters->getTranslator());
        $this->assertEquals(self::SUMMARY, $extraBookInfoParameters->getSummary());
    }
}
