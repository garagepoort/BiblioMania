<?php

class BuyInfoToJsonAdapter
{
    private $id;
    private $reason;
    private $shop;
    private $cityShop;
    private $countryShop;
    /** @var  PriceToJsonAdapter */
    private $buyPrice;

    /** @var  DateToJsonAdapter $date */
    private $date;

    public function __construct(BuyInfo $buyInfo)
    {
        $this->id = $buyInfo->id;
        $this->buyPrice = new PriceToJsonAdapter($buyInfo->price_payed, $buyInfo->currency);
        $this->shop = $buyInfo->shop;
        $this->reason = $buyInfo->reason;
        if($buyInfo->buy_date != null){
            $this->date = DateToJsonAdapter::fromDate($buyInfo->buy_date);
        }

        if($buyInfo->city != null){
            $this->cityShop = $buyInfo->city->name;
            if($buyInfo->city->country != null){
                $this->countryShop = $buyInfo->city->country->name;
            }
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "buyPrice" => $this->buyPrice->mapToJson(),
            "shop" => $this->shop,
            "reason" => $this->reason,
            "cityShop" => $this->cityShop,
            "countryShop" => $this->countryShop
        );
        if($this->date != null){
            $result['buyDate'] = $this->date->mapToJson();
        }
        return $result;
    }
}