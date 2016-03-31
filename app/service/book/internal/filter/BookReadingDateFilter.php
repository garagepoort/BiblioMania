<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookReadingDateFilter implements Filter
{

    public function getFilterId()
    {
        return FilterType::BOOK_READING_DATE;
    }

    public function getType()
    {
        return "partial-date";
    }

    public function getField()
    {
        return "Leesdatum";
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