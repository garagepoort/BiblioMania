<?php

class BaseFirstPrintFromJsonAdapter implements BaseFirstPrintInfoRequest
{

    /** @var string */
    private $title;
    /** @var string */
    private $subtitle;
    /** @var string */
    private $isbn;
    /** @var string */
    private $publisher;
    /** @var string */
    private $country;
    /** @var string */
    private $language;
    /** @var  DateFromJsonAdapter */
    private $publicationDate;

    function getTitle()
    {
        return $this->title;
    }

    function getSubtitle()
    {
        return $this->subtitle;
    }

    function getIsbn()
    {
        return $this->isbn;
    }

    function getPublisher()
    {
        return $this->publisher;
    }

    function getCountry()
    {
        return $this->country;
    }

    function getLanguage()
    {
        return $this->language;
    }

    /** @return DateFromJsonAdapter */
    function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * @param string $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
    }

    /**
     * @param string $publisher
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param DateFromJsonAdapter $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

}