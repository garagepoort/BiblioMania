<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;

class ElasticNumberFilterHandler implements FilterHandler
{
    private $field;

    /**
     * ElasticNumberFilterHandler constructor.
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }


    public function handleFilter(FilterValue $filter, $object = null)
    {
        Ensure::stringNotBlank('operator', $filter->getOperator());
        if($filter->getOperator() == FilterOperator::EQUALS){
            return FilterBuilder::range($this->field, $filter->getValue(), $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::GREATER_THAN){
            return FilterBuilder::greaterThan($this->field, $filter->getValue());
        }
        if($filter->getOperator() == FilterOperator::LESS_THAN){
            return FilterBuilder::lessThan($this->field, $filter->getValue());
        }

        throw new ServiceException('FilterOperator not supported');
    }
}