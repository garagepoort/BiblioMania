<?php

class CreateBookFromJsonAdapter implements BaseBookRequest
{

    /**
     * @var string
     * @required
     */
    private $title;
    /** @var string */
    private $subtitle;
    /** @var string */
    /** @required */
    private $isbn;
    /**
     * @var string
     * @required
     */
    private $genre;
    /**
     * @var TagFromJsonAdapter[]
     */
    private $tags;
    /**
     * @var string
     * @required
     */
    private $publisher;
    /**
     * @var string
     * @required
     */
    private $country;
    /**
     * @var string
     * @required
     */
    private $language;
    /** @var string */
    private $imageUrl;
    /**
     * @var DateFromJsonAdapter
     * @required
     */
    private $publicationDate;
    /** @var  int */
    /** @required */
    private $preferredAuthorId;

    /** @var  int */
    private $pages;
    /** @var  int */
    private $print;
    /** @var string */
    private $serie;
    /** @var string */
    private $publisherSerie;
    /** @var string */
    private $translator;


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
     * @param TagFromJsonAdapter[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @return string
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return TagFromJsonAdapter[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return DateFromJsonAdapter
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param DateFromJsonAdapter $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    /**
     * @return int
     */
    public function getPreferredAuthorId()
    {
        return $this->preferredAuthorId;
    }

    /**
     * @param int $preferredAuthorId
     */
    public function setPreferredAuthorId($preferredAuthorId)
    {
        $this->preferredAuthorId = $preferredAuthorId;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
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
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param string $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return string
     */
    public function getPublisherSerie()
    {
        return $this->publisherSerie;
    }

    /**
     * @param string $publisherSerie
     */
    public function setPublisherSerie($publisherSerie)
    {
        $this->publisherSerie = $publisherSerie;
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


}