<?php

class ChartDataToJsonAdapter
{
    private $labels;
    private $data;
    private $xLabel;
    private $title;

    /**
     * ChartDataToJsonAdapter constructor.
     */
    public function __construct(ChartData $chartData)
    {
        $this->title = $chartData->getTitle();
        $this->xLabel = $chartData->getXLabel();
        $this->labels = $chartData->getLabels();
        $this->data = $chartData->getData();
    }

    public function mapToJson(){
        return array(
            "title"=>$this->title,
            "xLabel"=>$this->xLabel,
            "labels"=>$this->labels,
            "data"=>$this->data
        );
    }


}