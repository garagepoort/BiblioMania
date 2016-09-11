<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class BookOwnedFilter implements Filter
{
    public function getFilterId()
    {
        return FilterType::BOOK_OWNED;
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "In bezit";
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }

}