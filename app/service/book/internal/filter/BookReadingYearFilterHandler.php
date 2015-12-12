<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookReadingYearFilterHandler implements FilterHandler
{

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->whereYear("reading_date.date", FilterOperator::getDatabaseOperator($operator), $value);
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