<?php

class FirstPrintInfoParameters {

    private $title;
    private $subtitle;
    private $isbn;
    private $publication_date;
    private $publisher;
    private $languageId;
    private $country;

    function __construct($title, $subtitle, $isbn, Date $publication_date = null, $publisher, $languageId, $country)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->isbn = $isbn;
        $this->publication_date = $publication_date;
        $this->publisher = $publisher;
        $this->languageId = $languageId;
        $this->country = $country;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function getLanguageId()
    {
        return $this->languageId;
    }

    public function getCountry()
    {
        return $this->country;
    }


}