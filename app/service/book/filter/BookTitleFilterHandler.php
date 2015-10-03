<?php

class BookTitleFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value)
    {
        return $queryBuilder->where("book.title", "LIKE", '%'.$value.'%');
    }

    public function getFilterId()
    {
        return "book.title";
    }

    public function getType()
    {
        return "text";
    }

    public function getField()
    {
        return "Titel boek";
    }
}