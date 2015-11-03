<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BuyInfoJsonMapper
{
    /** @var  DateToJsonMapper $dateToJsonMapper */
    private $dateToJsonMapper;

    public function __construct()
    {
        $this->dateToJsonMapper = App::make('DateToJsonMapper');
    }

    public function mapToJson(BuyInfo $buyInfo){
        $jsonArray = array(
            "id" => $buyInfo->id,
        );
        $jsonArray["date"] = $this->dateToJsonMapper->mapToJson($buyInfo->buy_date);
        $jsonArray["price"] = $buyInfo->price_payed;
        $jsonArray["currency"] = $buyInfo->currency;
        $jsonArray["shop"] = $buyInfo->shop;
        $jsonArray["reason"] = $buyInfo->reason;
        if($buyInfo->city != null){
            $jsonArray["city"] = $buyInfo->city->name;
            if($buyInfo->city->country != null){
                $jsonArray["country"] = $buyInfo->city->country->name;
            }
        }

        return $jsonArray;
    }
}