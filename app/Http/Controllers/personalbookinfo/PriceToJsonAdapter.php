<?php

class PriceToJsonAdapter
{
    /** @var  Integer */
    private $amount;
    /** @var  string */
    /** @required */
    private $currency;

    /**
     * PriceToJsonAdapter constructor.
     * @param int $amount
     * @param $currency
     */
    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function mapToJson(){
        return array(
            'amount'=>$this->amount,
            'currency'=>$this->currency);
    }
}