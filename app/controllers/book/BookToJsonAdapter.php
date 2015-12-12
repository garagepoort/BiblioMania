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

        $personal_book_info = $this->personalBookInfoRepository->findByBook($book->id);
        if($personal_book_info != null){
            $this->rating = $personal_book_info->rating;
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
            "author" => $this->author == null ? "" : $this->author
        );
        if($this->imageInformation != null){
            $result['image'] = $this->imageInformation->mapToJson();
        }
        return $result;
    }

}