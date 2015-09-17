<?php

class BuyInfoParameters {

    private $date;
    private $shop;
    private $city;
    private $reason;
    private $country;
    private $pricePayed;
    private $currency;

    function __construct(DateTime $date = null, $shop, $city, $reason, $country, $pricePayed, $currency)
    {
        $this->date = $date;
        $this->shop = $shop;
        $this->city = $city;
        $this->reason = $reason;
        $this->country = $country;
        $this->pricePayed = StringUtils::replace($pricePayed, ",", ".");
        $this->currency = $currency;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getShop()
    {
        return $this->shop;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getPricePayed()
    {
        return $this->pricePayed;
    }

    public function getCurrency(){
        return $this->currency;
    }


}