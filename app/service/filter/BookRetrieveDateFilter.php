<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class BookRetrieveDateFilter implements Filter
{

    public function getFilterId()
    {
        return FilterType::BOOK_RETRIEVE_DATE;
    }

    public function getType()
    {
        return "date";
    }

    public function getField()
    {
        return "Verkregen datum";
    }

    public function getSupportedOperators(){
        return null;
    }

    public function getGroup()
    {
        return "personal";
    }
}