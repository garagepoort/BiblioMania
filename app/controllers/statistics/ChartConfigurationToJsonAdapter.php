<?php

class ChartConfigurationToJsonAdapter
{
    private $id;
    private $title;
    private $xProperty;
    private $filters;

    public function __construct(ChartConfiguration $chartConfiguration)
    {
        $this->id = $chartConfiguration->id;
        $this->title = $chartConfiguration->title;
        $this->filters = json_decode($chartConfiguration->filters, true);
        $this->xProperty = $chartConfiguration->xProperty;
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "xProperty" => $this->xProperty,
            "filters" => $this->filters
        );
        return $result;
    }
}