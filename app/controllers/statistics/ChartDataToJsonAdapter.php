<?php

class ChartDataToJsonAdapter
{
    private $labels;
    private $data;
    private $series;
    private $title;

    /**
     * ChartDataToJsonAdapter constructor.
     */
    public function __construct(ChartData $chartData)
    {
        $this->title = $chartData->getTitle();
        $this->labels = $chartData->getLabels();
        $this->data = $chartData->getData();
    }

    public function mapToJson(){
        return array(
            "title"=>$this->title,
            "labels"=>$this->labels,
            "data"=>$this->data
        );
    }


}