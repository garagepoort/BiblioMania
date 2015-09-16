<?php

class FirstPrintInfoParameters {

    private $title;
    private $subtitle;
    private $isbn;
    private $publication_date;
    private $publisher;
    private $language;
    private $country;

    function __construct($title, $subtitle, $isbn, Date $publication_date = null, $publisher, $language = null, $country)
    {
        $this->title = StringUtils::emptyToNull($title);
        $this->subtitle = StringUtils::emptyToNull($subtitle);
        $this->isbn = StringUtils::emptyToNull($isbn);
        $this->publication_date = $publication_date;
        $this->publisher = StringUtils::emptyToNull($publisher);
        $this->language = $language;
        $this->country = StringUtils::emptyToNull($country);
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

    public function getLanguage()
    {
        return $this->language;
    }

    public function getCountry()
    {
        return $this->country;
    }

}