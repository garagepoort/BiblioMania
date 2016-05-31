<?php

namespace e2e\datasetbuilders;


class PriceBuilder implements \PriceRequest
{

    private $amount;
    private $currency;

    /**
     * PriceBuilder constructor.
     * @param $amount
     * @param $currency
     */
    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }


    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }


}