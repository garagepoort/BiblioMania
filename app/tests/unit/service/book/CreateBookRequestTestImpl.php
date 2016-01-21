<?php

class CreateBookRequestTestImpl implements BaseBookRequest
{

    private $title = 'title';
    private $subtitle = 'subtitle';
    private $isbn = '1234567890123';
    private $genre = 'genre';
    private $publisher = 'publisher';
    private $country = 'country';
    private $language = 'language';
    private $imageUrl = 'imageUrl';
    private $pages = '100';
    private $print = '5';
    private $serie;
    private $publisherSerie;
    private $translator = 'translator';
    private $summary = 'summary';

    private $publicationDate;
    private $tags;
    private $preferredAuthorId = 13221;

    /**
     * CreateBookRequestTestImpl constructor.
     */
    public function __construct()
    {
        $this->publicationDate = new DateRequestTestImpl();
    }


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

    function getGenre()
    {
        return $this->genre;
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

    function getTags()
    {
        return $this->tags;
    }

    /** @return DateRequest */
    function getPublicationDate()
    {
        return $this->publicationDate;
    }

    function getPreferredAuthorId()
    {
        return $this->preferredAuthorId;
    }

    function getImageUrl()
    {
        return $this->imageUrl;
    }

    function getPages()
    {
        return $this->pages;
    }

    function getPrint()
    {
        return $this->print;
    }

    function getSerie()
    {
        return $this->serie;
    }

    function getPublisherSerie()
    {
        return $this->publisherSerie;
    }

    function getTranslator()
    {
        return $this->translator;
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
     * @param string $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
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
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param string $pages
     */
    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    /**
     * @param string $print
     */
    public function setPrint($print)
    {
        $this->print = $print;
    }

    /**
     * @param string $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @param string $publisherSerie
     */
    public function setPublisherSerie($publisherSerie)
    {
        $this->publisherSerie = $publisherSerie;
    }

    /**
     * @param string $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param DateRequestTestImpl $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }


    function getSummary()
    {
        return $this->summary;
    }
}