<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookIsPersonalFilterHandler implements FilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        if($value){
            return $queryBuilder->whereIn("book.id", function($q){
                $q->select('book_id')
                    ->from('personal_book_info')
                    ->where("personal_book_info.user_id", "=", Auth::user()->id);
            });
        }else{
            return $queryBuilder->whereNotIn("book.id", function($q){
                $q->select('book_id')
                    ->from('personal_book_info')
                    ->where("personal_book_info.user_id", "=", Auth::user()->id);
            });
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