<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class BookOwnedFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
    {
        return FilterBuilder::match('personalBookInfos.inCollection', $filter->getValue());
    }

}