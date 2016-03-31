<?php

class ChartConditionFromJsonAdapter implements CreateChartConditionRequest
{

    /**
     * @var string
     * @required
     */
    private $property;

    /** @var string */
    /** @required */
    private $operator;

    /** @var string */
    /** @required */
    private $value;


    function getProperty()
    {
        return $this->property;
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
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * @param mixed $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }


}