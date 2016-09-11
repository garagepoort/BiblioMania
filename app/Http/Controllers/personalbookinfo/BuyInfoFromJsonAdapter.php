<?php

class BuyInfoFromJsonAdapter implements BuyInfoRequest
{
    /** @var  DateFromJsonAdapter */
    private $buyDate;
    /** @var  PriceFromJsonAdapter */
    private $buyPrice;
    /** @var  string */
    private $reason;
    /** @var  string */
    private $shop;
    /** @var  string */
    private $cityShop;
    /** @var  string */
    private $countryShop;

    /**
     * @return DateFromJsonAdapter
     */
    public function getBuyDate()
    {
        return $this->buyDate;
    }

    /**
     * @param DateFromJsonAdapter $buyDate
     */
    public function setBuyDate($buyDate)
    {
        $this->buyDate = $buyDate;
    }

    /**
     * @return PriceFromJsonAdapter
     */
    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    /**
     * @param PriceFromJsonAdapter $buyPrice
     */
    public function setBuyPrice($buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param string $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return string
     */
    public function getCityShop()
    {
        return $this->cityShop;
    }

    /**
     * @param string $cityShop
     */
    public function setCityShop($cityShop)
    {
        $this->cityShop = $cityShop;
    }

    /**
     * @return string
     */
    public function getCountryShop()
    {
        return $this->countryShop;
    }

    /**
     * @param string $countryShop
     */
    public function setCountryShop($countryShop)
    {
        $this->countryShop = $countryShop;
    }


}