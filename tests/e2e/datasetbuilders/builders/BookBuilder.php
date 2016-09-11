<?php

namespace e2e\datasetbuilders;

use DateRequest;
use PriceRequest;

class BookBuilder implements \BaseBookRequest
{

    private $title;
    private $subtitle;
    private $isbn;
    private $genre;
    private $publisher;
    private $country;
    private $language;
    private $tags;
    /** @var  DateRequest $publicationDate */
    private $publicationDate;
    private $preferredAuthorId;
    private $imageUrl;
    private $pages;
    private $print;
    private $serie;
    private $publisherSerie;
    private $translator;
    private $summary;
    /** @var  PriceRequest $retailPrice */
    private $retailPrice;

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
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function withGenre($genre)
    {
        $this->genre = $genre;
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
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     */
    public function withTags($tags)
    {
        $this->tags = $tags;
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
    public function getPreferredAuthorId()
    {
        return $this->preferredAuthorId;
    }

    /**
     * @param mixed $preferredAuthorId
     */
    public function withPreferredAuthorId($preferredAuthorId)
    {
        $this->preferredAuthorId = $preferredAuthorId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $imageUrl
     */
    public function withImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function withPages($pages)
    {
        $this->pages = $pages;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrint()
    {
        return $this->print;
    }

    /**
     * @param mixed $print
     */
    public function withPrint($print)
    {
        $this->print = $print;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function withSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublisherSerie()
    {
        return $this->publisherSerie;
    }

    /**
     * @param mixed $publisherSerie
     */
    public function withPublisherSerie($publisherSerie)
    {
        $this->publisherSerie = $publisherSerie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param mixed $translator
     */
    public function withTranslator($translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param mixed $summary
     */
    public function withSummary($summary)
    {
        $this->summary = $summary;
        return $this;
    }

    /**
     * @return PriceRequest
     */
    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    /**
     * @param PriceRequest $retailPrice
     */
    public function withRetailPrice($retailPrice)
    {
        $this->retailPrice = $retailPrice;
        return $this;
    }

    public static function buildDefault($authorId){
        $book = new BookBuilder();
        $book->withTitle('title')
            ->withCountry("België")
            ->withLanguage("Nederlands")
            ->withPublisher("Uitgever")
            ->withPublicationDate(1,1,2011)
            ->withGenre("YA")
            ->withIsbn("1234567890123")
            ->withPages(12)
            ->withPreferredAuthorId($authorId)
            ->withRetailPrice(new PriceBuilder(123, 'EUR'));
        return $book;
    }

}
