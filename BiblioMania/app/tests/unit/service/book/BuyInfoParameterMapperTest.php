<?php

class BuyInfoParameterMapperTest extends TestCase {
    const SHOP = 'shop';
    const CITY = 'city';
    const REASON = 'recommended';
    const COUNTRY = 'country';
    const DATE = '01/12/1991';
    const PRICE_PAYED = 1234;

    /** @var  BuyInfoParameterMapper */
    private $buyInfoParameterMapper;

    public function setUp(){
        parent::setUp();
        $this->buyInfoParameterMapper = App::make('BuyInfoParameterMapper');
    }

    public function testCreate_createsCorrect(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('buy_info_buy_date', null)->andReturn(self::DATE);
        $mockInput->shouldReceive('input')->with('buy_info_shop', null)->andReturn(self::SHOP);
        $mockInput->shouldReceive('input')->with('buy_info_city', null)->andReturn(self::CITY);
        $mockInput->shouldReceive('input')->with('buy_info_reason', null)->andReturn(self::REASON);
        $mockInput->shouldReceive('input')->with('buy_info_country', null)->andReturn(self::COUNTRY);
        $mockInput->shouldReceive('input')->with('buy_info_price_payed', null)->andReturn(self::PRICE_PAYED);
        Input::swap($mockInput);

        $buyInfoParameters = $this->buyInfoParameterMapper->create();

        $this->assertEquals(self::SHOP, $buyInfoParameters->getShop());
        $this->assertEquals(self::CITY, $buyInfoParameters->getCity());
        $this->assertEquals(self::REASON, $buyInfoParameters->getReason());
        $this->assertEquals(self::COUNTRY, $buyInfoParameters->getCountry());
        $this->assertEquals(self::PRICE_PAYED, $buyInfoParameters->getPricePayed());
        $this->assertEquals("1", $buyInfoParameters->getDate()->format('d'));
        $this->assertEquals("12", $buyInfoParameters->getDate()->format('m'));
        $this->assertEquals("1991", $buyInfoParameters->getDate()->format('Y'));
    }

    public function testCreate_createsWithDateNullIfNoDateGiven(){
        $mockInput = Mockery::mock('\Illuminate\Http\Request');
        $mockInput->shouldReceive('input')->with('buy_info_buy_date', null)->andReturn("");
        $mockInput->shouldReceive('input')->with('buy_info_shop', null)->andReturn(self::SHOP);
        $mockInput->shouldReceive('input')->with('buy_info_city', null)->andReturn(self::CITY);
        $mockInput->shouldReceive('input')->with('buy_info_reason', null)->andReturn(self::REASON);
        $mockInput->shouldReceive('input')->with('buy_info_country', null)->andReturn(self::COUNTRY);
        $mockInput->shouldReceive('input')->with('buy_info_price_payed', null)->andReturn(self::PRICE_PAYED);
        Input::swap($mockInput);

        $buyInfoParameters = $this->buyInfoParameterMapper->create();

        $this->assertNull($buyInfoParameters->getDate());
    }
}
