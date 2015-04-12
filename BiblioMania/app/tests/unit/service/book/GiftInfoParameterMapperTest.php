<?php

class GiftInfoParameterMapperTest extends TestCase {
    const FROM = 'from';
    const OCCASION = 'occasion';
    const DATE = '01/12/1991';

    /** @var  GiftInfoParameterMapper */
    private $giftInfoParameterMapper;

    public function setUp(){
        parent::setUp();
        $this->giftInfoParameterMapper = App::make('GiftInfoParameterMapper');
    }

    public function testCreate_createsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('gift_info_receipt_date', null)->andReturn(self::DATE);
        $mockInput->shouldReceive('input')->with('gift_info_from', null)->andReturn(self::FROM);
        $mockInput->shouldReceive('input')->with('gift_info_occasion', null)->andReturn(self::OCCASION);
        Input::swap($mockInput);

        $giftInfoParameters = $this->giftInfoParameterMapper->create();

        $this->assertEquals(self::FROM, $giftInfoParameters->getFrom());
        $this->assertEquals(self::OCCASION, $giftInfoParameters->getOccasion());
        $this->assertEquals("1", $giftInfoParameters->getDate()->format('d'));
        $this->assertEquals("12", $giftInfoParameters->getDate()->format('m'));
        $this->assertEquals("1991", $giftInfoParameters->getDate()->format('Y'));
    }

    public function testCreate_createsWithDateNullIfNoDateGiven(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('gift_info_receipt_date', null)->andReturn("");
        $mockInput->shouldReceive('input')->with('gift_info_from', null)->andReturn(self::FROM);
        $mockInput->shouldReceive('input')->with('gift_info_occasion', null)->andReturn(self::OCCASION);
        Input::swap($mockInput);

        $giftInfoParameters = $this->giftInfoParameterMapper->create();

        $this->assertNull($giftInfoParameters->getDate());
    }
}
