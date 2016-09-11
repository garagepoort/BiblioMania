<?php

class CreateOeuvreItemFromJsonAdapter implements CreateOeuvreItemRequest
{
    /** @var int */
    private $authorId;
    /** @var int */
    private $publicationYear;
    /** @var string */
    private $title;

    /**
     * @return int
     */
    public function getPublicationYear()
    {
        return $this->publicationYear;
    }

    /**
     * @param int $publicationYear
     */
    public function setPublicationYear($publicationYear)
    {
        $this->publicationYear = $publicationYear;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

}