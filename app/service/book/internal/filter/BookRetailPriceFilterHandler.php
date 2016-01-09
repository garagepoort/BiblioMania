<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookRetailPriceFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
//        Ensure::stringNotBlank('book.retail.price', $filter->getOperator());
//        return $queryBuilder->where("book.retail_price", FilterOperator::getDatabaseOperator($filter->getOperator()), $filter->getValue());
    }

    public function getFilterId()
    {
        return "book-retail_price";
    }

    public function getType()
    {
        return "number";
    }

    public function getField()
    {
        return "Cover prijs";
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
        return "book";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}