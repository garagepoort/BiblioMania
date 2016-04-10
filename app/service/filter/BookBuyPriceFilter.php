<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookBuyPriceFilter implements Filter
{

    public function getFilterId()
    {
        return FilterType::BOOK_BUY_PRICE;
    }

    public function getType()
    {
        return "number";
    }

    public function getField()
    {
        return "Aankoop prijs";
    }

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"=", "value"=>FilterOperator::EQUALS),
            array("key"=>">", "value"=>FilterOperator::GREATER_THAN),
            array("key"=>"<", "value"=>FilterOperator::LESS_THAN)
        );
    }

    public function getGroup()
    {
        return "personal";
    }
}