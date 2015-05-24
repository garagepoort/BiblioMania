<?php

class ExtraBookInfoParameters {

    private $pages;
    private $print;
    private $book_serie;
    private $publisher_serie;
    private $translator;

    function __construct($pages, $print, $book_serie, $publisher_serie, $translator)
    {
        $this->pages = $pages;
        $this->print = $print;
        $this->book_serie = $book_serie;
        $this->publisher_serie = $publisher_serie;
        $this->translator = $translator;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function getPrint()
    {
        return $this->print;
    }

    public function getBookSerie()
    {
        return $this->book_serie;
    }

    public function getPublisherSerie()
    {
        return $this->publisher_serie;
    }

    public function getTranslator()
    {
        return $this->translator;
    }
}