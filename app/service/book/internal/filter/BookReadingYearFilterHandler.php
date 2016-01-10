<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookReadingYearFilterHandler implements FilterHandler
{

    public function handleFilter(Filter $filter)
    {
        Ensure::stringNotBlank('reading.year', $filter->getOperator());

        $beginDate = $filter->getValue() . '-01-01';
        $endDate = $filter->getValue() . '-12-31';

        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range('personalBookInfos.readingDates.date', $beginDate, $endDate);
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan('personalBookInfos.readingDates.date', $endDate);
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan('personalBookInfos.readingDates.date', $beginDate);
        }

        throw new ServiceException('FilterOperator not supported');

    }

    public function getFilterId()
    {
        return "personal-readingyear";
    }

    public function getType()
    {
        return "number";
    }

    public function getField()
    {
        return "Leesjaar";
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
        return $queryBuilder;
    }
}