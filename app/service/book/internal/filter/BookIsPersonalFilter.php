<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class BookIsPersonalFilter implements Filter
{
    public function getFilterId()
    {
        return FilterType::BOOK_IS_PERSONAL;
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "Heeft persoonlijke informatie";
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }
}