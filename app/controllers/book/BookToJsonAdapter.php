<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookToJsonAdapter
{

    private $id;
    private $title;
    private $subtitle;
    private $isbn;
    private $author;
    private $image;
    private $personalBookInfoId;
    private $read = false;
    /** @var  PriceToJsonAdapter */
    private $retailPrice;
    /** @var  ImageToJsonAdapter */
    private $spriteImage;
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

        foreach($book->personal_book_infos->all() as $personal_book_info){
            if($personal_book_info->user_id == Auth::user()->id){
                $this->personalBookInfoId = $personal_book_info->id;

                if(count($personal_book_info->reading_dates) > 0){
                    $this->read = true;
                }
                break;
            }
        }

        if($book->preferredAuthor() != null){
            $this->author = $book->preferredAuthor()->name . " " . $book->preferredAuthor()->firstname;
        }

        if(!StringUtils::isEmpty($book->coverImage)){
            $imageToJsonAdapter = new ImageToJsonAdapter();
            $imageToJsonAdapter->fromBook($book);
            $this->spriteImage = $imageToJsonAdapter;

            $baseUrl = URL::to('/');
            $this->image = $baseUrl . "/bookImages/" . $book->coverImage;
        }

//        $this->oeuvreItemIds = array_map(function ($item) { return $item->id; }, $book->book_from_authors->all());
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle == null ? "" : $this->subtitle,
            "isbn" => $this->isbn,
            "read" => $this->read,
            "image" => $this->image,
            "author" => $this->author == null ? "" : $this->author
        );

        if($this->personalBookInfoId != null){
            $result['personalBookInfoId'] = $this->personalBookInfoId;
        }

        if($this->spriteImage != null){
            $result['spriteImage'] = $this->spriteImage->mapToJson();
        }
        if($this->retailPrice != null){
            $result['retailPrice'] = $this->retailPrice->mapToJson();
        }
        return $result;
    }

}