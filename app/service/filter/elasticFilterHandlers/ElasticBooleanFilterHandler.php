<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class ElasticBooleanFilterHandler implements FilterHandler
{
    private $field;

    /**
     * ElasticBooleanFilterHandler constructor.
     * @param string $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }


    public function handleFilter(FilterValue $filter, $object = null)
    {
        return FilterBuilder::match($this->field, $filter->getValue());
    }

}