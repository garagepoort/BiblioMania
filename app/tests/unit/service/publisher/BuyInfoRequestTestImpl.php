<?php

class BuyInfoRequestTestImpl implements BuyInfoRequest
{

    /** @var DateRequestTestImpl $buyDate */
    private $buyDate;
    /** @var PriceRequestTestImpl */
    private $buyPrice;
    private $reason;
    private $shop;
    private $cityShop;
    private $countryShop;

    /**
     * @return DateRequest
     */
    function getBuyDate()
    {
        return $this->buyDate;
    }

    /**
     * @return PriceRequest
     */
    function getBuyPrice()
    {
        return $this->buyPrice;
    }

    function getReason()
    {
        return $this->reason;
    }

    function getShop()
    {
        return $this->shop;
    }

    function getCityShop()
    {
        return $this->cityShop;
    }

    function getCountryShop()
    {
        return $this->countryShop;
    }

    /**
     * @param DateRequestTestImpl $buyDate
     */
    public function setBuyDate($buyDate)
    {
        $this->buyDate = $buyDate;
    }

    /**
     * @param PriceRequestTestImpl $buyPrice
     */
    public function setBuyPrice($buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @param mixed $shop
     */
    public function setShop($shop)
    {
        $this->shop = $shop;
    }

    /**
     * @param mixed $cityShop
     */
    public function setCityShop($cityShop)
    {
        $this->cityShop = $cityShop;
    }

    /**
     * @param mixed $countryShop
     */
    public function setCountryShop($countryShop)
    {
        $this->countryShop = $countryShop;
    }


}