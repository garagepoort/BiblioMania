<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class BookReadFilter implements Filter
{
    public function getFilterId()
    {
        return FilterType::BOOK_READ;
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "Gelezen";
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }

}