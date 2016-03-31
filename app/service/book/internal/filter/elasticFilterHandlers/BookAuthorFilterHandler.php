<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;

class BookAuthorFilterHandler implements FilterHandler
{

    public function handleFilter(FilterValue $filter, $object = null)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){ return $item->value; }, (array) $filter->getValue());

        return FilterBuilder::terms('authors.id', $options);
    }

}