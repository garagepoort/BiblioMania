<?php

use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;

class FilterValueTestImpl implements FilterValue
{

    private $id;
    private $value;
    /** @var  FilterOperator */
    private $operator;

    function getId()
    {
        return $this->id;
    }

    function getValue()
    {
        return $this->value;
    }

    function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @param FilterOperator $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }


}