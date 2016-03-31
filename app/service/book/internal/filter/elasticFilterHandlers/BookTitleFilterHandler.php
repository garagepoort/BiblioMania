<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class BookTitleFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
    {
        return FilterBuilder::wildcard('title', '*' . $filter->getValue() . '*');
    }

}