<?php

class BookReadFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value)
    {
        return $queryBuilder->where("personal_book_info.read", "=", StringUtils::toBoolean($value));
    }

    public function getFilterId()
    {
        return "personal.read";
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "Gelezen";
    }
}