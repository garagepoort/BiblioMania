<?php

class PriceRequestTestImpl implements PriceRequest
{

    private $amount = 123;
    private $currency = 'EUR';

    function getAmount()
    {
        return $this->amount;
    }

    function getCurrency()
    {
        return $this->currency;
    }
}