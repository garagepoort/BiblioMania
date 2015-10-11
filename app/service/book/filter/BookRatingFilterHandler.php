<?php

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
        return array("Geen rating" =>0 , "1"=>1, "2"=>2, "3"=>3, "4"=>4, "5"=>5, "6"=>6, "7"=>7, "8"=>8, "9"=>9, "10"=>10);
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
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