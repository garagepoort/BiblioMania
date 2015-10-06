<?php

class BookTitleFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->where("book.title", "LIKE", '%'.$value.'%');
    }

    public function getFilterId()
    {
        return "book-title";
    }

    public function getType()
    {
        return "text";
    }

    public function getField()
    {
        return "Titel boek";
    }

    public function getSupportedOperators()
    {
        return array("="=>FilterOperator::EQUALS);
    }
}