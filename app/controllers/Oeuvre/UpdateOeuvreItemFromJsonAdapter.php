<?php

class UpdateOeuvreItemFromJsonAdapter implements UpdateOeuvreItemRequest
{
    /** @var  int[] */
    private $linkedBooks;
    /** @var  int */
    private $authorId;
    /** @var string */
    private $title;
    /** @var int */
    private $publicationYear;

    /**
     * @return int[]
     */
    public function getLinkedBooks()
    {
        return $this->linkedBooks;
    }

    /**
     * @param int[] $linkedBooks
     */
    public function setLinkedBooks($linkedBooks)
    {
        $this->linkedBooks = $linkedBooks;
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


}