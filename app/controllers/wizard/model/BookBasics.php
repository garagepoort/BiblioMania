<?php

class BookBasics
{
    /**
     * @var string
     * @required
     */
    private $title;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $isbn;
    /**
     * @var integer
     * @required
     */
    private $genre;
    /**
     * @var string[]
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
     * @param int $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @param string[] $tags
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

    public function toJson(){
        return array(
            "title"=>$this->title,
            "subtitle"=>$this->subtitle,
            "isbn"=>$this->isbn,
            "language"=>$this->language,
            "publisher"=>$this->publisher,
            "tags"=>$this->tags
        );
    }
}