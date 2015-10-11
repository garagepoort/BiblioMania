<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;

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
        return array("="=>FilterOperator::EQUALS, ">"=>FilterOperator::GREATER_THAN, "<"=>FilterOperator::LESS_THAN);
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