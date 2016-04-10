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

    /** @var string */
    /** @required */
    private $xLabel;

    /** @required */
    private $filters;

    function getTitle()
    {
        return $this->title;
    }

    function getXProperty()
    {
        return $this->xProperty;
    }

    function getFilters()
    {
        return $this->filters;
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
     * @param mixed $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    public function getXLabel()
    {
        return $this->xLabel;
    }

    public function setXLabel($xLabel)
    {
        $this->xLabel = $xLabel;
    }

}