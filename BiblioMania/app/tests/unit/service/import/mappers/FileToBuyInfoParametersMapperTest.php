<?php

class FileToBuyInfoParametersMapperTest extends TestCase {
    /** @var  FileToBuyInfoParametersMapper */
    private $fileToBuyInfoParametersMapperTest;

    public function setUp(){
        parent::setUp();
        $this->fileToBuyInfoParametersMapperTest = App::make('FileToBuyInfoParametersMapper');
    }

    public function test_map_worksCorrect(){
        $line_values = [50];

        $line_values[LineMapping::BuyInfoBuyDate] = "12-03-14";
        $line_values[LineMapping::BuyInfoShop] = "shopBuy";
        $line_values[LineMapping::BuyInfoPricePayed] = "45";

        $expectedDate = DateTime::createFromFormat('d-m-y', "12-03-14");

        $parameters = $this->fileToBuyInfoParametersMapperTest->map($line_values);

        $this->assertEquals($expectedDate, $parameters->getDate());
        $this->assertEquals("shopBuy", $parameters->getShop());
        $this->assertEquals("45", $parameters->getPricePayed());
    }
}
