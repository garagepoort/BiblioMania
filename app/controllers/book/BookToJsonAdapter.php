<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookToJsonAdapter
{

    private $id;
    private $title;
    private $subtitle;
    private $isbn;
    private $author;
    private $personalBookInfoId;
    private $oeuvreItemId;
    private $read = false;
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
            $this->personalBookInfoId = $personal_book_info->id;

            if(count($personal_book_info->reading_dates) > 0){
                $this->read = true;
            }
        }
        if($book->preferredAuthor() != null){
            $this->author = $book->preferredAuthor()->name . " " . $book->preferredAuthor()->firstname;
        }

        if(!StringUtils::isEmpty($book->coverImage)){
            $imageToJsonAdapter = new ImageToJsonAdapter();
            $imageToJsonAdapter->fromBook($book);
            $this->imageInformation = $imageToJsonAdapter;
        }

        if($book->book_from_author_id !== null){
            $this->oeuvreItemId = $book->book_from_author_id;
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle == null ? "" : $this->subtitle,
            "isbn" => $this->isbn,
            "read" => $this->read,
            "author" => $this->author == null ? "" : $this->author
        );

        if($this->personalBookInfoId != null){
            $result['personalBookInfoId'] = $this->personalBookInfoId;
        }
        if($this->oeuvreItemId != null){
            $result['oeuvreItemId'] = $this->oeuvreItemId;
        }

        if($this->imageInformation != null){
            $result['image'] = $this->imageInformation->mapToJson();
        }
        if($this->retailPrice != null){
            $result['retailPrice'] = $this->retailPrice->mapToJson();
        }
        return $result;
    }

}