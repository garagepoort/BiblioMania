<?php

class BookRetailPriceFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->where("book.retail_price", FilterOperator::getDatabaseOperator($operator), $value);
    }

    public function getFilterId()
    {
        return "book-retail_price";
    }

    public function getType()
    {
        return "number";
    }

    public function getField()
    {
        return "Cover prijs";
    }

    public function getSupportedOperators()
    {
        return array("="=>FilterOperator::EQUALS, ">"=>FilterOperator::GREATER_THAN, "<"=>FilterOperator::LESS_THAN);
    }
}