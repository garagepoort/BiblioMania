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
}