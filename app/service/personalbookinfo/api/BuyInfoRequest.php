<?php

interface BuyInfoRequest
{

    /**
     * @return DateRequest
     */
    function getBuyDate();

    /**
     * @return PriceRequest
     */
    function getBuyPrice();

    function getReason();

    function getShop();

    function getCityShop();

    function getCountryShop();
}