<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookOwnedFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
//        return $queryBuilder->where("personal_book_info.owned", "=", $filter->getValue());
    }

    public function getFilterId()
    {
        return "personal-owned";
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "In bezit";
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}