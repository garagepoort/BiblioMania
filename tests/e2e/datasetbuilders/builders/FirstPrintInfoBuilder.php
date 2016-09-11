<?php

namespace e2e\datasetbuilders;

use DateRequest;
use PriceRequest;

class FirstPrintInfoBuilder implements \CreateFirstPrintInfoRequest
{

    private $title;
    private $subtitle;
    private $isbn;
    private $publisher;
    private $country;
    private $language;
    /** @var  DateRequest $publicationDate */
    private $publicationDate;
    private $bookIdToLink;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function withTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @param mixed $subtitle
     */
    public function withSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     * @return $this
     */
    public function withIsbn($isbn)
    {
        $this->isbn = $isbn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function withPublisher($publisher)
    {
        $this->publisher = $publisher;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function withCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     */
    public function withLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return DateRequest
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param DateRequest $publicationDate
     */
    public function withPublicationDate($day, $month, $year)
    {
        $date = new DateBuilder();
        $date
            ->withDay($day)
            ->withMonth($month)
            ->withYear($year);

        $this->publicationDate = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBookIdToLink()
    {
        return $this->bookIdToLink;
    }

    /**
     * @param mixed $bookIdToLink
     */
    public function withBookIdToLink($bookIdToLink)
    {
        $this->bookIdToLink = $bookIdToLink;
        return $this;
    }


    public static function buildDefault(){
        $book = new FirstPrintInfoBuilder();
        $book->withTitle('title')
            ->withSubtitle('subtitle')
            ->withCountry("België")
            ->withLanguage("Nederlands")
            ->withPublisher("Uitgever")
            ->withPublicationDate(1,1,1991)
            ->withIsbn("1234567890133");
        return $book;
    }

}
