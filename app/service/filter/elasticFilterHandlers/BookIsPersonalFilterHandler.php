<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class BookIsPersonalFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
    {
        if($filter->getValue()){
            return FilterBuilder::exists('personalBookInfos');
        }else{
            return FilterBuilder::missing('personalBookInfos');
        }
    }
}