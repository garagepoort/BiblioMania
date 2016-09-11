<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class BookBuyDateFilter implements Filter
{

    public function getFilterId()
    {
        return FilterType::BOOK_BUY_DATE;
    }

    public function getType()
    {
        return "date";
    }

    public function getField()
    {
        return "Aankoop datum";
    }

    public function getSupportedOperators(){
        return null;
    }

    public function getGroup()
    {
        return "personal";
    }
}