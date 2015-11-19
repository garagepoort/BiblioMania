<?php

class UpdateBookExtrasFromJsonAdapter implements UpdateBookExtrasRequest
{

    /**
     * @var integer
     * @required
     */
    private $id;
    /**
     * @var string
     */
    private $coverPriceCurrency;
    /**
     * @var float
     */
    private $coverPrice;
    /**
     * @var int
     */
    private $pages;
    /**
     * @var int
     */
    private $print;
    /**
     * @var string
     */
    private $translator;
    /**
     * @var string
     */
    private $state;
    /**
     * @var string
     */
    private $summary;
    /**
     * @var string
     */
    private $oldTags;
    /**
     * @var string
     */
    private $bookSeries;
    /**
     * @var string
     */
    private $publisherSeries;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCoverPriceCurrency()
    {
        return $this->coverPriceCurrency;
    }

    /**
     * @param string $coverPriceCurrency
     */
    public function setCoverPriceCurrency($coverPriceCurrency)
    {
        $this->coverPriceCurrency = $coverPriceCurrency;
    }

    /**
     * @return float
     */
    public function getCoverPrice()
    {
        return $this->coverPrice;
    }

    /**
     * @param float $coverPrice
     */
    public function setCoverPrice($coverPrice)
    {
        $this->coverPrice = $coverPrice;
    }

    /**
     * @return int
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param int $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return int
     */
    public function getPrint()
    {
        return $this->print;
    }

    /**
     * @param int $print
     */
    public function setPrint($print)
    {
        $this->print = $print;
    }

    /**
     * @return string
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param string $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getOldTags()
    {
        return $this->oldTags;
    }

    /**
     * @param string $oldTags
     */
    public function setOldTags($oldTags)
    {
        $this->oldTags = $oldTags;
    }

    /**
     * @return string
     */
    public function getBookSeries()
    {
        return $this->bookSeries;
    }

    /**
     * @param string $bookSeries
     */
    public function setBookSeries($bookSeries)
    {
        $this->bookSeries = $bookSeries;
    }

    /**
     * @return string
     */
    public function getPublisherSeries()
    {
        return $this->publisherSeries;
    }

    /**
     * @param string $publisherSeries
     */
    public function setPublisherSeries($publisherSeries)
    {
        $this->publisherSeries = $publisherSeries;
    }
}