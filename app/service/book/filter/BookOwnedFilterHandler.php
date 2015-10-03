<?php

class BookOwnedFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value)
    {
        return $queryBuilder->where("personal_book_info.owned", "=", StringUtils::toBoolean($value));
    }

    public function getFilterId()
    {
        return "personal.owned";
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "In bezit";
    }
}