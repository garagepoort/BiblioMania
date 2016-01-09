<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookReadingYearFilterHandler implements FilterHandler
{

    public function handleFilter(Filter $filter)
    {
//        Ensure::stringNotBlank('reading.year', $filter->getOperator());
//        return $queryBuilder
//            ->whereYear("reading_date.date", FilterOperator::getDatabaseOperator($filter->getOperator()), $filter->getValue());
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