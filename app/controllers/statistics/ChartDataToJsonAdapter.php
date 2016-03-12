<?php

class ChartDataToJsonAdapter
{
    private $labels;
    private $data;
    private $series;

    /**
     * ChartDataToJsonAdapter constructor.
     */
    public function __construct(ChartData $chartData)
    {
        $this->labels = $chartData->getLabels();
        $this->data = $chartData->getData();
        $this->series = $chartData->getSeries();
    }

    public function mapToJson(){
        return array(
            "labels"=>$this->labels,
            "series"=>$this->series,
            "data"=>$this->data
        );
    }


}