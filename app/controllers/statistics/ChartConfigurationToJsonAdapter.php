<?php

class ChartConfigurationToJsonAdapter
{
    private $id;
    private $title;
    private $xProperty;

    /** @var  DateToJsonAdapter $date */
    private $date;

    public function __construct(ChartConfiguration $chartConfiguration)
    {
        $this->id = $chartConfiguration->id;
        $this->title = $chartConfiguration->title;
        $this->xProperty = $chartConfiguration->xProperty;
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "xProperty" => $this->xProperty
        );
        return $result;
    }
}