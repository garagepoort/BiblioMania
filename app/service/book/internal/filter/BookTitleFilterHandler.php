<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookTitleFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, Filter $filter)
    {
        return $queryBuilder->where("book.title", "LIKE", '%' . $filter->getValue() . '%');
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

    public function getSupportedOperators(){
        return null;
    }

    public function getGroup()
    {
        return "book";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}