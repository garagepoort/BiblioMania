<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookJsonMapper
{
    /** @var  PersonalBookInfoJsonMapper $personalBookInfoJsonMapper */
    private $personalBookInfoJsonMapper;
    /** @var  FirstPrintInfoJsonMapper $firstPrintInfoJsonMapper */
    private $firstPrintInfoJsonMapper;
    /** @var  DateToJsonMapper $dateToJsonMapper */
    private $dateToJsonMapper;

    public function __construct()
    {
        $this->personalBookInfoJsonMapper = App::make('PersonalBookInfoJsonMapper');
        $this->firstPrintInfoJsonMapper = App::make('FirstPrintInfoJsonMapper');
        $this->dateToJsonMapper = App::make('DateToJsonMapper');
    }


    public function mapToJson(Book $book){
        list($imageHeight, $imageWidth, $bookImage) = $this->getCoverImageFromBook($book);

        $publisher = $book->publisher != null ? $book->publisher->name : "";
        $language = $book->language != null ? $book->language->language : "";
        $country = $book->country != null ? $book->country->name : "";

        $jsonArray = array(
            "id" => $book->id,
            "title" => $book->title,
            "isbn" => $book->ISBN,
            "author" => $book->preferredAuthor()->firstname . ' ' . $book->preferredAuthor()->name,
            "subtitle" => $book->subtitle,
            "publisher" => $publisher,
            "publicationDate" => $this->dateToJsonMapper->mapToJson($book->publication_date),
            "summary" => $book->summary,
            "country" => $country,
            "language" => $language,
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
            "progress" => $book->wizard_step,
            "personalBookInfo" => $this->personalBookInfoJsonMapper->mapToJson($book->personal_book_info),
            "firstPrintInfo" => $this->firstPrintInfoJsonMapper->mapToJson($book->first_print_info)
        );

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