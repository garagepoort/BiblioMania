<?php


class BookAuthorToJsonAdapter
{
    /** @var  Book */
    private $book;

    /** @var  AuthorToJsonAdapter */
    private $preferredAuthor;

    /** @var  AuthorToJsonAdapter[] */
    private $secondaryAuthors;

    /**
     * BookAuthorToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
        if($book->preferredAuthor() != null){
            $this->preferredAuthor = new AuthorToJsonAdapter($book->preferredAuthor());
        }
        $this->secondaryAuthors = array_map(function($item){ return new AuthorToJsonAdapter($item); }, $book->secondaryAuthors());
    }


    public function mapToJson()
    {
        $result = array();
        if($this->preferredAuthor != null){
            $result["preferredAuthor"] = $this->preferredAuthor->mapToJson();
        }

        if($this->secondaryAuthors != null){
            $result["secondaryAuthors"] = array_map(function($item){
                /** @var AuthorToJsonAdapter $item */
                return $item->mapToJson();
            },$this->secondaryAuthors);
        }
        return $result;
    }

}