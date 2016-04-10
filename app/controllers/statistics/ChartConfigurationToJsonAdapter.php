<?php

class ChartConfigurationToJsonAdapter
{
    private $id;
    private $title;
    private $xProperty;
    private $xLabel;
    private $filters;

    public function __construct(ChartConfiguration $chartConfiguration)
    {
        $this->id = $chartConfiguration->id;
        $this->title = $chartConfiguration->title;
        $this->filters = json_decode($chartConfiguration->filters, true);
        $this->xProperty = $chartConfiguration->xProperty;
        $this->xLabel = $chartConfiguration->xLabel;
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "xProperty" => $this->xProperty,
            "xLabel" => $this->xLabel,
            "filters" => $this->filters
        );
        return $result;
    }
}