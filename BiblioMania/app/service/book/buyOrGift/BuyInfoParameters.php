<?php

class BuyInfoParameters {

    private $date;
    private $shop;
    private $city;
    private $reason;
    private $country;
    private $pricePayed;

    function __construct(DateTime $date = null, $shop, $city, $reason, $country, $pricePayed)
    {
        $this->date = $date;
        $this->shop = $shop;
        $this->city = $city;
        $this->reason = $reason;
        $this->country = $country;
        $this->pricePayed = $pricePayed;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function getPricePayed()
    {
        return $this->pricePayed;
    }


}