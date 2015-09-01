<?php

class BookFromAuthorParameters {

    private $id;
    private $title;
    private $year;

    function __construct($title, $year)
    {
        $this->title = $title;
        $this->year = $year;
    }

    public static function createWithId($id, $title, $year){
        $bookFromAuthorParam = new BookFromAuthorParameters($title, $year);
        $bookFromAuthorParam->id = $id;
        return $bookFromAuthorParam;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getId()
    {
        return $this->id;
    }
}