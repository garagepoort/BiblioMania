<?php

use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;

class BookRatingFilterHandler implements OptionsFilterHandler
{
    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->whereIn("personal_book_info.rating", $value);
    }

    public function getFilterId()
    {
        return "personal-rating";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Rating";
    }

    public function getOptions()
    {
        $options= array();
        array_push($options, array("key" => "Geen rating", "value" => 0));
        array_push($options, array("key" => "1", "value" => 1));
        array_push($options, array("key" => "2", "value" => 2));
        array_push($options, array("key" => "3", "value" => 3));
        array_push($options, array("key" => "4", "value" => 4));
        array_push($options, array("key" => "5", "value" => 5));
        array_push($options, array("key" => "6", "value" => 6));
        array_push($options, array("key" => "7", "value" => 7));
        array_push($options, array("key" => "8", "value" => 8));
        array_push($options, array("key" => "9", "value" => 9));
        array_push($options, array("key" => "10", "value" => 10));
        return $options;
    }

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"in", "value"=>FilterOperator::IN)
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