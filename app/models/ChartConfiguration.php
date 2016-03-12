<?php

class ChartConfiguration
{

    private $id;
    private $title;
    private $xProperty;
    private $series;

    /**
     * ChartConfiguration constructor.
     * @param $title
     * @param $xProperty
     * @param $series
     */
    public function __construct($title, $xProperty, $series)
    {
        $this->title = $title;
        $this->xProperty = $xProperty;
        $this->series = $series;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getXProperty()
    {
        return $this->xProperty;
    }

    /**
     * @return mixed
     */
    public function getSeries()
    {
        return $this->series;
    }


}