<?php

class BookFromAuthorParameters {

    private $title;
    private $year;

    function __construct($title, $year)
    {
        $this->title = $title;
        $this->year = $year;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getYear()
    {
        return $this->year;
    }


}