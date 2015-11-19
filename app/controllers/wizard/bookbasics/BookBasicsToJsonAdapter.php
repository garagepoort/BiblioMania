<?php


class BookBasicsToJsonAdapter
{
    /** @var  string */
    private $title;
    /** @var  string */
    private $subtitle;
    /** @var  string */
    private $isbn;
    /** @var  string */
    private $genre;
    /** @var  TagToJsonAdapter[]  */
    private $tags;
    /** @var  DateToJsonAdapter */
    private $publicationDate;
    /** @var  string */
    private $publisher;
    /** @var  string */
    private $language;
    /** @var  string */
    private $country;

    /**
     * BookBasicsToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
        $this->title = $book->title;
        $this->subtitle = $book->subtitle;
        $this->isbn = $book->ISBN;
        $this->genre = $book->genre->name;
        $this->tags = array_map(function ($item) { return new TagToJsonAdapter($item); }, $book->tags->all());;

        if($book->publication_date != null){
            $this->publicationDate = new DateToJsonAdapter($book->publication_date);
        }
        if ($book->publisher != null) {
            $this->publisher = $book->publisher->name;
        }
        if ($book->language != null) {
            $this->language = $book->language->language;
        }
        if ($book->country != null) {
            $this->country = $book->country->name;
        }
    }

    public function mapToJson(){
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
            $result["publicationDate"] = $this->publicationDate->mapToJson();
        }

        if($this->tags != null){
            $result["tags"] = array_map(function($item){
                /** @var TagToJsonAdapter $item */
                return $item->mapToJson();
            },$this->tags);
        }

        return $result;
    }
}