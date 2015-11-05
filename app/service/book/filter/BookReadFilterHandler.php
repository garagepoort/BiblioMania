<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookReadFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->where("personal_book_info.read", "=", StringUtils::toBoolean($value));
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

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"=", "value"=>FilterOperator::EQUALS)
        );
    }

    public function getGroup()
    {
        return "personal";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}