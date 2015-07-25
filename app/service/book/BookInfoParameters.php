<?php

class BookInfoParameters
{
    private $book_id;
    private $title;
    private $subtitle;
    private $isbn;
    private $genre;
    private $publication_date;
    private $publisherName;
    private $countryName;
    private $language;
    private $retail_price;
    private $tags;
    private $currency;

    function __construct($book_id, $title, $subtitle, $isbn, $genre, Date $publication_date = null, $publisherName, $countryName, $language, $retail_price, $currency, $tags)
    {
        $this->book_id = $book_id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->isbn = $isbn;
        $this->genre = $genre;
        $this->publication_date = $publication_date;
        $this->publisherName = $publisherName;
        $this->countryName = $countryName;
        $this->language = $language;
        $this->retail_price = StringUtils::replace($retail_price, ",", ".");
        $this->tags = $tags;
        $this->currency = $currency;
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
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return Date
     */
    public function getPublicationDate()
    {
        return $this->publication_date;
    }

    public function getPublisherName()
    {
        return $this->publisherName;
    }

    public function getCountryName()
    {
        return $this->countryName;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getRetailPrice()
    {
        return $this->retail_price;
    }

    public function getBookId()
    {
        return $this->book_id;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

}