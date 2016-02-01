<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookReadingDateFilterHandler implements FilterHandler
{

    public function handleFilter(Filter $filter)
    {
        Ensure::stringNotBlank('reading.year', $filter->getOperator());

        /** @var DateRequest $dateRequest */
        $dateRequest = $filter->getValue();

        Ensure::objectIsInstanceOf('date', $dateRequest, 'DateRequest');
        Ensure::stringNotBlank('year of date',$dateRequest->getYear());

        if(StringUtils::isEmpty($dateRequest->getMonth()) || $dateRequest->getMonth() == 0){
            $beginDate = $dateRequest->getYear() . '-01-01';
            $endDate = $dateRequest->getYear() . '-12-31';
        }else if(StringUtils::isEmpty($dateRequest->getDay()) || $dateRequest->getDay() == 0){
            $beginDate = $dateRequest->getYear() . '-' . $dateRequest->getMonth() . '-01';
            $endDate = $dateRequest->getYear() . '-' . $dateRequest->getMonth() . '-31';
        }else{
            $beginDate = DateFormatter::dateRequestToFormattedDate($dateRequest);
            $endDate = DateFormatter::dateRequestToFormattedDate($dateRequest);
        }

        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range('personalBookInfos.readingDates.date', $beginDate, $endDate);
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan('personalBookInfos.readingDates.date', $beginDate);
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan('personalBookInfos.readingDates.date', $beginDate);
        }

        throw new ServiceException('FilterOperator not supported');

    }

    public function getFilterId()
    {
        return "personal-readingdate";
    }

    public function getType()
    {
        return "partial-date";
    }

    public function getField()
    {
        return "Leesdatum";
    }

    public function getSupportedOperators()
    {
        return array(
            array("key"=>"=", "value"=>FilterOperator::EQUALS),
            array("key"=>">", "value"=>FilterOperator::GREATER_THAN),
            array("key"=>"<", "value"=>FilterOperator::LESS_THAN)
        );
    }

    public function getGroup()
    {
        return "personal";
    }

}