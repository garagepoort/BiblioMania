<?php

class BookReadingYearFilterHandler implements FilterHandler
{

    public function handleFilter($queryBuilder, $value)
    {
        return $queryBuilder->whereYear("reading_date.date", "=", $value);
    }

    public function getFilterId()
    {
        return "personal.readingyear";
    }

    public function getType()
    {
        return "text";
    }

    public function getField()
    {
        return "Leesjaar";
    }
}