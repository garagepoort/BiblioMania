<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookBuyPriceFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
        Ensure::stringNotBlank('buy.price.filter.operator.not.null',$filter->getOperator());

        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range('personalBookInfos.buyInfo.price', $filter->getValue(), $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan('personalBookInfos.buyInfo.price', $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan('personalBookInfos.buyInfo.price', $filter->getValue());
        }

        throw new ServiceException('FilterOperator not supported');
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
}