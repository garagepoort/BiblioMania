<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookReadFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
        if($filter->getValue()){
            return FilterBuilder::exists('personalBookInfos.readingDates');
        }else{
            return FilterBuilder::missing('personalBookInfos.readingDates');
        }
    }

    public function getFilterId()
    {
        return "personal-read";
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "Gelezen";
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "personal";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}