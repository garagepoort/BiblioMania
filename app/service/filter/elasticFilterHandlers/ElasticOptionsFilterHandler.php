<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\StringUtils;

class ElasticOptionsFilterHandler implements FilterHandler
{

    private $field;

    /**
     * ElasticOptionsFilterHandler constructor.
     * @param $field
     */
    public function __construct($field)
    {
        $this->field = $field;
    }

    public function handleFilter(FilterValue $filter, $object = null)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        return FilterBuilder::terms($this->field, $options);
    }

}