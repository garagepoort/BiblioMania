<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 25/10/15
 * Time: 21:13
 */
class BookJsonMapper
{

    public function mapBookToJson(Book $book){
        list($imageHeight, $imageWidth, $bookImage) = $this->getCoverImageFromBook($book);
        $jsonArray = array(
            "id" => $book->id,
            "title" => $book->title,
            "isbn" => $book->isbn,
            "author" => $book->preferredAuthor()->firstname . ' ' . $book->preferredAuthor()->name,
            "subtitle" => $book->subtitle,
            "publisher" => $book->publisher->name,
            "publicationDate" => $book->publication_date,
            "summary" => $book->summary,
            "country" => $book->country->name,
            "language" => $book->language->language,
            "imageHeight" => $imageHeight,
            "imageWidth" => $imageWidth,
            "spritePointer" => $book->spritePointer,
            "coverImage" => $bookImage,
            "currency" => $book->currency,
            "retailPrice" => $book->retail_price,
            "pages" => $book->number_of_pages,
            "print" => $book->print,
            "translator" => $book->translator,
            "useSpriteImage" => $book->useSpriteImage,
            "read" => $book->personal_book_info->read
        );

        $buy_info = $book->personal_book_info->buy_info;
        if($buy_info != null){
            $jsonArray["buyDate"] = $buy_info->buy_date;
            $jsonArray["buyPrice"] = $buy_info->price_payed;
            $jsonArray["buyShop"] = $buy_info->price_payed;
            $jsonArray["buyReason"] = $buy_info->reason;
            if($buy_info->city != null){
                $jsonArray["buyCity"] = $buy_info->city->name;
                if($buy_info->city->country != null){
                    $jsonArray["buyCountry"] = $buy_info->city->country->name;
                }
            }
        }else{

        }

        return $jsonArray;
    }

    public function getCoverImageFromBook($item)
    {
        $imageHeight = $item->imageHeight;
        $imageWidth = $item->imageWidth;
        $username = Auth::user()->username;
        $baseUrl = URL::to('/');
        $bookImage = $baseUrl . "/bookImages/" . $username . "/sprite.png";


        if ($item->useSpriteImage == false) {
            $bookImage = $baseUrl . "/bookImages/" . $username . "/" . $item->coverImage;
        }

        if (StringUtils::isEmpty($item->coverImage)) {
            $bookImage = $baseUrl . "/images/questionCover.png";
            $imageHeight = 214;
            $imageWidth = 142;
            return array($imageHeight, $imageWidth, $bookImage);
        }
        return array($imageHeight, $imageWidth, $bookImage);
    }
}