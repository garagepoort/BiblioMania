<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookToJsonAdapter
{

    private $id;
    private $title;
    private $subtitle;
    private $isbn;
    private $rating;
    private $author;
    private $owned = false;
    /** @var  PriceToJsonAdapter */
    private $retailPrice;
    /** @var  ImageToJsonAdapter */
    private $imageInformation;
    /** @var  PersonalBookInfoRepository */
    private $personalBookInfoRepository;

    /**
     * BookToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');

        $this->id = $book->id;
        $this->title = $book->title;
        $this->subtitle = $book->subtitle;
        $this->isbn = $book->ISBN;
        if($book->retail_price){
            $this->retailPrice = new PriceToJsonAdapter($book->retail_price, $book->currency);
        }

        $personal_book_info = $this->personalBookInfoRepository->findByBook($book->id);
        if($personal_book_info != null){
            $this->rating = $personal_book_info->rating;
            $this->owned = true;
        }
        if($book->preferredAuthor() != null){
            $this->author = $book->preferredAuthor()->name . " " . $book->preferredAuthor()->firstname;
        }
        if(!StringUtils::isEmpty($book->coverImage)){
            $this->imageInformation = new ImageToJsonAdapter($book);
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle == null ? "" : $this->subtitle,
            "isbn" => $this->isbn,
            "rating" => $this->rating,
            "owned" => $this->owned,
            "author" => $this->author == null ? "" : $this->author
        );
        if($this->imageInformation != null){
            $result['image'] = $this->imageInformation->mapToJson();
        }
        if($this->retailPrice != null){
            $result['retailPrice'] = $this->retailPrice->mapToJson();
        }
        return $result;
    }

}