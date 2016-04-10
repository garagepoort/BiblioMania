<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class ElasticStringFilterHandler implements FilterHandler
{

    private $field;

    /**
     * ElasticStringFilterHandler constructor.
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }


    public function handleFilter(FilterValue $filter, $object = null)
    {
        return FilterBuilder::wildcard($this->field, '*' . $filter->getValue() . '*');
    }
}