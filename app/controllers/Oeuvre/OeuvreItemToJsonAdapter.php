<?php

class OeuvreItemToJsonAdapter
{
    /** @var int */
    private $id;
    /** @var string */
    private $authorId;
    /** @var string */
    private $title;
    /** @var string */
    private $linkedBooks;
    /** @var int */
    private $publicationYear;
    /** @var string */
    private $state;

    /**
     * OeuvreItemToJsonAdapter constructor.
     */
    public function __construct(BookFromAuthor $bookFromAuthor)
    {
        $this->id = $bookFromAuthor->id;
        $this->title = $bookFromAuthor->title;
        $this->publicationYear = $bookFromAuthor->publication_year;
        $this->authorId = $bookFromAuthor->author->id;
        $this->state = count($bookFromAuthor->books) > 0 ? 'LINKED' : 'UNLINKED';

        $this->linkedBooks = array_map(function ($item) {
            return $item->id;
        }, $bookFromAuthor->books->all());
    }

    public function mapToJson()
    {
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "authorId" => $this->authorId,
            "linkedBooks" => $this->linkedBooks,
            "publicationYear" => $this->publicationYear,
            "state" => $this->state
        );
    }
}