<?php

class BuyInfoToJsonAdapter
{
    private $id;
    private $price;
    private $currency;
    private $shop;
    private $reason;
    private $city;
    private $country;

    /** @var  DateToJsonAdapter $date */
    private $date;

    public function __construct(BuyInfo $buyInfo)
    {
        $this->id = $buyInfo->id;
        $this->price = $buyInfo->price;
        $this->currency = $buyInfo->currency;
        $this->shop = $buyInfo->shop;
        $this->reason = $buyInfo->reason;
        if($buyInfo->buy_date != null){
            $this->date = DateToJsonAdapter::fromDate($buyInfo->buy_date);
        }

        if($buyInfo->city != null){
            $this->city = $buyInfo->city->name;
            if($buyInfo->city->country != null){
                $this->country = $buyInfo->city->country;
            }
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "price" => $this->price,
            "currency" => $this->currency,
            "shop" => $this->shop,
            "reason" => $this->reason,
            "city" => $this->city,
            "country" => $this->country
        );
        if($this->date != null){
            $result['date'] = $this->date->mapToJson();
        }
        return $result;
    }
}