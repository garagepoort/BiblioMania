<?php

class BuyInfoParameters {

    private $date;
    private $shop;
    private $city;
    private $recommended_by;
    private $country;
    private $pricePayed;

    function __construct(DateTime $date = null, $shop, $city, $recommended_by, $country, $pricePayed)
    {
        $this->date = $date;
        $this->shop = $shop;
        $this->city = $city;
        $this->recommended_by = $recommended_by;
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
    public function getRecommendedBy()
    {
        return $this->recommended_by;
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