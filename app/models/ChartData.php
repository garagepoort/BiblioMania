<?php

class ChartData
{
    private $labels;
    private $data;
    private $series;

    /**
     * ChartData constructor.
     * @param $labels
     * @param $data
     * @param $series
     */
    public function __construct($labels, $data, $series)
    {
        $this->labels = $labels;
        $this->data = $data;
        $this->series = $series;
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

    /**
     * @return mixed
     */
    public function getSeries()
    {
        return $this->series;
    }




}