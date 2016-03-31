<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookBuyPriceFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
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

}