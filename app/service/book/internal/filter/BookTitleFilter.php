<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookTitleFilter implements Filter
{
    public function getFilterId()
    {
        return FilterType::BOOK_TITLE;
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

}