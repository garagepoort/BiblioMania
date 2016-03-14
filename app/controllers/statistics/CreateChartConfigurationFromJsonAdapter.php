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

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $xProperty
     */
    public function setXProperty($xProperty)
    {
        $this->xProperty = $xProperty;
    }

    /**
     * @param mixed $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }


}