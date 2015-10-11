<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;

class BookOwnedFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->where("personal_book_info.owned", "=", StringUtils::toBoolean($value));
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

    public function getSupportedOperators()
    {
        return array("="=>FilterOperator::EQUALS);
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