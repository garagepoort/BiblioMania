<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookRetailPriceFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
    {
        Ensure::stringNotBlank('book.retail.price', $filter->getOperator());
        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range('retailPrice.amount', $filter->getValue(), $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan('retailPrice.amount', $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan('retailPrice.amount', $filter->getValue());
        }

        throw new ServiceException('FilterOperator not supported');
    }
}