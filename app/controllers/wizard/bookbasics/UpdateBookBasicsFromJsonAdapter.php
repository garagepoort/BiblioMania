<?php

class UpdateBookBasicsFromJsonAdapter implements UpdateBookBasicsRequest
{

    /**
     * @var integer
     * @required
     */
    private $id;
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
     * @var string
     * @required
     */
    private $genre;
    /**
     * @var TagData[]
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
     * @var DateJsonData
     * @required
     */
    private $publicationDate;


    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param TagData[] $tags
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
     * @return TagData[]
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
     * @return DateJsonData
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param DateJsonData $publicationDate
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;
    }

    public function toJson(){
        $result = array(
            "title"=>$this->title,
            "subtitle"=>$this->subtitle,
            "isbn"=>$this->isbn,
            "language"=>$this->language,
            "publisher"=>$this->publisher,
            "genre"=>$this->genre,
            "country"=>$this->country
        );

        if($this->publicationDate != null){
            $result["publicationDate"] = $this->publicationDate->toJson();
        }

        if($this->tags != null){
            $result["tags"] = array_map(function($item){
                /** @var TagData $item */
                return $item->toJson();
            },$this->tags);
        }

        return $result;
    }
}