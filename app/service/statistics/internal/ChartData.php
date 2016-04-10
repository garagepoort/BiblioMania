<?php

class ChartData
{
    private $title;
    private $xLabel;
    private $type;
    private $labels;
    private $data;

    /**
     * ChartData constructor.
     * @param $title
     * @param $type
     * @param $labels
     * @param $data
     * @param $series
     */
    public function __construct($title, $xLabel, $type, $labels, $data)
    {
        $this->title = $title;
        $this->xLabel = $xLabel;
        $this->labels = $labels;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public function getXLabel()
    {
        return $this->xLabel;
    }

}