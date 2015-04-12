<?php

class PersonalBookInfoParameterMapperTest extends TestCase {
    const OWNED = true;
    const REASON_NOT_OWNED = "reason";
    const REVIEW = "review";
    const RATING = 3;
    const READING_DATES = "1/2/1991,2/3/1999,";

    /** @var  PersonalBookInfoParameterMapper */
    private $personalBookInfoParameterMapper;

    public function setUp(){
        parent::setUp();
        $this->personalBookInfoParameterMapper = App::make('PersonalBookInfoParameterMapper');
    }

    public function testCreate_mapsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('personal_info_owned', null)->andReturn(self::OWNED);
        $mockInput->shouldReceive('input')->with('personal_info_reason_not_owned', null)->andReturn(self::REASON_NOT_OWNED);
        $mockInput->shouldReceive('input')->with('personal_info_review', null)->andReturn(self::REVIEW);
        $mockInput->shouldReceive('input')->with('personal_info_rating', null)->andReturn(self::RATING);
        $mockInput->shouldReceive('input')->with('personal_info_reading_dates', null)->andReturn(self::READING_DATES);
        Input::swap($mockInput);

        $personalBookInfoParameters = $this->personalBookInfoParameterMapper->create();

        $this->assertEquals(self::OWNED, $personalBookInfoParameters->getOwned());
        $this->assertEquals(self::REASON_NOT_OWNED, $personalBookInfoParameters->getReasonNotOwned());
        $this->assertEquals(self::REVIEW, $personalBookInfoParameters->getReview());
        $this->assertEquals(self::RATING, $personalBookInfoParameters->getRating());

        $this->assertCount(2, $personalBookInfoParameters->getReadingDates());

        $this->assertEquals("1", array_values($personalBookInfoParameters->getReadingDates())[0]->format('d'));
        $this->assertEquals("2", array_values($personalBookInfoParameters->getReadingDates())[0]->format('m'));
        $this->assertEquals("1991", array_values($personalBookInfoParameters->getReadingDates())[0]->format('Y'));

        $this->assertEquals("2", array_values($personalBookInfoParameters->getReadingDates())[1]->format('d'));
        $this->assertEquals("3", array_values($personalBookInfoParameters->getReadingDates())[1]->format('m'));
        $this->assertEquals("1999", array_values($personalBookInfoParameters->getReadingDates())[1]->format('Y'));
    }
}
