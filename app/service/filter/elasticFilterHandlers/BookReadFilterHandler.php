<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class BookReadFilterHandler implements FilterHandler
{
    public function handleFilter(FilterValue $filter, $object = null)
    {
        if($filter->getValue()){
            return FilterBuilder::exists('personalBookInfos.readingDates');
        }else{
            return FilterBuilder::missing('personalBookInfos.readingDates');
        }
    }

}
