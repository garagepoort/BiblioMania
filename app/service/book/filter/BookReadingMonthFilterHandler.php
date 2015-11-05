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
        $options= array();
        array_push($options, array("key" => "januari", "value" => 1));
        array_push($options, array("key" => "februari", "value" => 2));
        array_push($options, array("key" => "maart", "value" => 3));
        array_push($options, array("key" => "april", "value" => 4));
        array_push($options, array("key" => "mei", "value" => 5));
        array_push($options, array("key" => "juni", "value" => 6));
        array_push($options, array("key" => "juli", "value" => 7));
        array_push($options, array("key" => "augustus", "value" => 8));
        array_push($options, array("key" => "september", "value" => 9));
        array_push($options, array("key" => "oktober", "value" => 10));
        array_push($options, array("key" => "november", "value" => 11));
        array_push($options, array("key" => "december", "value" => 12));
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