<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Bendani\PhpCommon\Utils\StringUtils;

class SqlDateRangeFilterHandler implements FilterHandler
{

    private $field;

    /**
     * SqlDateRangeFilterHandler constructor.
     * @param $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }


    public function handleFilter(\Bendani\PhpCommon\FilterService\Model\FilterValue $filter, $queryBuilder = null)
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
            return $queryBuilder->where($this->field, '>=', $beginDate)
                ->where($this->field, '<=', $endDate);
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return $queryBuilder->where($this->field, '>', $beginDate);
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return $queryBuilder->where($this->field, '<', $beginDate);
        }

        throw new ServiceException('FilterOperator not supported');
    }
}