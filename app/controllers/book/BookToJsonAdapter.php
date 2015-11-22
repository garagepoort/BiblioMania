<?php

class BookToJsonAdapter
{

    private $title;
    private $subtitle;
    private $isbn;

    /**
     * BookToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
        $this->title = $book->title;
        $this->subtitle = $book->subtitle;
        $this->isbn = $book->ISBN;
    }

    public function mapToJson(){
        return array(
            "title"=>$this->title,
            "subtitle"=>$this->subtitle,
            "isbn"=>$this->isbn,
        );
    }

}