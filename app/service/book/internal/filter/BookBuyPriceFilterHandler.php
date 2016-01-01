<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookBuyPriceFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, Filter $filter)
    {
        Ensure::stringNotBlank('buy.price.filter.operator.not.null',$filter->getOperator());
        return $queryBuilder
            ->where("buy_info_price_join.price_payed", FilterOperator::getDatabaseOperator($filter->getOperator()), $filter->getValue());
    }

    public function getFilterId()
    {
        return "personal-buy_price";
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

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder->join("buy_info as buy_info_price_join", "buy_info_price_join.personal_book_info_id", "=", "personal_book_info.id");
    }
}