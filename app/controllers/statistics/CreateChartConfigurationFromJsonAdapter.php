<?php

class CreateChartConfigurationFromJsonAdapter implements CreateChartConfigurationRequest
{

    /**
     * @var string
     * @required
     */
    private $title;

    /** @var string */
    /** @required */
    private $xProperty;

    /** @var ChartConditionFromJsonAdapter */
    /** @required */
    private $conditions;

    function getTitle()
    {
        return $this->title;
    }

    function getXProperty()
    {
        return $this->xProperty;
    }

    function getConditions()
    {
        return $this->conditions;
    }
}