<?php

use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;

class BookReadingMonthFilterHandler implements OptionsFilterHandler
{

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder
            ->whereIn(DB::raw("MONTH(reading_date.date)"), $value);
    }

    public function getFilterId()
    {
        return "personal-readingmonth";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Leesmaand";
    }

    public function getOptions()
    {
        return array(
            "januari"=>1,
            "februari"=>2,
            "maart"=>3,
            "april"=>4,
            "mei"=>5,
            "juni"=>6,
            "juli"=>7,
            "augustus"=>8,
            "september"=>9,
            "oktober"=>10,
            "november"=>11,
            "december"=>12,
            );
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