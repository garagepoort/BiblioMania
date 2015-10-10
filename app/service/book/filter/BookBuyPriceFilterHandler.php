<?php

class BookBuyPriceFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->leftJoin("buy_info", "buy_info.personal_book_info_id", "=", "personal_book_info.id")
            ->where("buy_info.price_payed", FilterOperator::getDatabaseOperator($operator), $value);
    }

    public function getFilterId()
    {
        return "personal-buy_price";
    }

    public function getType()
    {
        return "number";
    }

    public function getField()
    {
        return "Aankoop prijs";
    }

    public function getSupportedOperators()
    {
        return array("="=>FilterOperator::EQUALS, ">"=>FilterOperator::GREATER_THAN, "<"=>FilterOperator::LESS_THAN);
    }
}