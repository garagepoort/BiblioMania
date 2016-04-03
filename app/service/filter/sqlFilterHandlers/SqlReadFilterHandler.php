<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class SqlReadFilterHandler implements FilterHandler
{

    public function handleFilter(FilterValue $filterValue, $queryBuilder = null)
    {
        if($filterValue->getValue()){
            return $queryBuilder->whereNotNull('reading_date.id');
        }else{
            return $queryBuilder->whereNull('reading_date.id');
        }
    }
}