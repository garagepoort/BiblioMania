<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;

class BookIsPersonalFilterHandler implements FilterHandler
{
    public function handleFilter(Filter $filter)
    {
        if($filter->getValue()){
            return FilterBuilder::exists('personalBookInfos');
        }else{
            return FilterBuilder::missing('personalBookInfos');
        }
    }

    public function getFilterId()
    {
        return "isPersonal";
    }

    public function getType()
    {
        return "boolean";
    }

    public function getField()
    {
        return "Heeft persoonlijke informatie";
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