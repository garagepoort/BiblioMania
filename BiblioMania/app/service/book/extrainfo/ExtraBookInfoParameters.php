<?php

class ExtraBookInfoParameters {

    private $pages;
    private $print;
    private $book_serie;
    private $publisher_serie;

    function __construct($pages, $print, $book_serie, $publisher_serie)
    {
        $this->pages = $pages;
        $this->print = $print;
        $this->book_serie = $book_serie;
        $this->publisher_serie = $publisher_serie;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @return mixed
     */
    public function getPrint()
    {
        return $this->print;
    }

    /**
     * @return mixed
     */
    public function getBookSerie()
    {
        return $this->book_serie;
    }

    /**
     * @return mixed
     */
    public function getPublisherSerie()
    {
        return $this->publisher_serie;
    }


}