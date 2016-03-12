<?php

class ChartConfigurationToJsonAdapter
{
    private $id;
    private $title;
    private $xProperties;

    /** @var  DateToJsonAdapter $date */
    private $date;

    public function __construct(ChartConfiguration $chartConfiguration)
    {
        $this->id = $chartConfiguration->getId();
        $this->title = $chartConfiguration->getTitle();
        $this->xProperties = $chartConfiguration->getXProperty();
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "xProperties" => $this->xProperties
        );
        return $result;
    }
}