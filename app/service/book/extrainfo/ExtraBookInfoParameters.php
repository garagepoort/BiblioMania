<?php

class ExtraBookInfoParameters {

    private $pages;
    private $print;
    private $book_serie;
    private $publisher_serie;
    private $translator;
    private $summary;
    private $state;
    private $oldTags;
    private $retailPrice;
    private $retailPriceCurrency;

    function __construct($pages, $print, $book_serie, $publisher_serie, $translator, $summary, $state, $tags)
    {
        $this->pages = $pages;
        $this->print = $print;
        $this->book_serie = $book_serie;
        $this->publisher_serie = $publisher_serie;
        $this->translator = $translator;
        $this->summary = $summary;
        $this->state = $state;
        $this->oldTags = $tags;
    }

    public static function createForExtras($pages, $print, $book_serie, $publisher_serie, $translator, $summary, $state, $tags, $book_retail_price, $book_retail_price_currency){
        $extraBookInfoParameters = new ExtraBookInfoParameters($pages, $print, $book_serie, $publisher_serie, $translator, $summary, $state, $tags);
        $extraBookInfoParameters->retailPrice = $book_retail_price;
        $extraBookInfoParameters->retailPriceCurrency = $book_retail_price_currency;
        return $extraBookInfoParameters;
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

    public function getSummary()
    {
        return $this->summary;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getOldTags()
    {
        return $this->oldTags;
    }

    /**
     * @return mixed
     */
    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    /**
     * @return mixed
     */
    public function getRetailPriceCurrency()
    {
        return $this->retailPriceCurrency;
    }


}