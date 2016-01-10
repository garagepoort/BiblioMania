<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookRetailPriceFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
        Ensure::stringNotBlank('book.retail.price', $filter->getOperator());
        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range('retail_price', $filter->getValue(), $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan('retail_price', $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan('retail_price', $filter->getValue());
        }

        throw new ServiceException('FilterOperator not supported');
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