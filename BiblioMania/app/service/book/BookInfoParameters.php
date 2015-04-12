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
    private $language_id;
    private $retail_price;

    function __construct($book_id, $title, $subtitle, $isbn, $genre, Date $publication_date, $publisherName, $countryName, $language_id, $retail_price)
    {
        $this->book_id = $book_id;
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->isbn = $isbn;
        $this->genre = $genre;
        $this->publication_date = $publication_date;
        $this->publisherName = $publisherName;
        $this->countryName = $countryName;
        $this->language_id = $language_id;
        $this->retail_price = $retail_price;
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

    public function getLanguageId()
    {
        return $this->language_id;
    }

    public function getRetailPrice()
    {
        return $this->retail_price;
    }

    public function getBookId()
    {
        return $this->book_id;
    }
}