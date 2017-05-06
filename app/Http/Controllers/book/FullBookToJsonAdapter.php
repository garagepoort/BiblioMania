<?php

use Bendani\PhpCommon\Utils\StringUtils;

class FullBookToJsonAdapter
{
    /** @var  PersonalBookInfoRepository */
    private $personalBookInfoRepository;
    /** @var WishlistService*/
    private $wishlistService;

    private $id;
    private $title;
    private $subtitle;
    private $isbn;
    private $summary;
    private $country;
    private $currency;
    private $retailPrice;
    private $pages;
    private $print;
    private $translator;
    private $language;
    private $publisher;
    private $publisherSerie;
    private $serie;
    private $genre;
    private $image;
    private $onWishlist;

    /** @var  OeuvreItemToJsonAdapter */
    private $oeuvreItems = [];

    /** @var  TagToJsonAdapter[] */
    private $tags;

    /** @var  FirstPrintInfoToJsonAdapter */
    private $firstPrintInfo;
    /** @var  DateToJsonAdapter */
    private $publicationDate;
    /** @var  AuthorToJsonAdapter[] */
    private $authors;
    /** @var  PersonalBookInfoToJsonAdapter */
    private $personalBookInfo;

    public function __construct(Book $book)
    {
        $this->personalBookInfoRepository = App::make('PersonalBookInfoRepository');
        $this->wishlistService = App::make('WishlistService');


        $publisher = $book->publisher != null ? $book->publisher->name : "";
        $language = $book->language != null ? $book->language->language : "";
        $country = $book->country != null ? $book->country->name : "";

        $this->id = $book->id;
        $this->title = $book->title;
        $this->subtitle = $book->subtitle;
        $this->isbn = $book->ISBN;
        $this->genre = $book->genre->name;
        $this->publisher = $publisher;
        $this->country = $country;
        $this->language = $language;
        $this->translator = $book->translator;
        $this->pages = $book->number_of_pages;
        $this->print = $book->print;
        $this->summary = $book->summary;
        $this->retailPrice = new PriceToJsonAdapter($book->retail_price, $book->currency);
        $this->publisherSerie = $book->publisher_serie == null ? null : $book->publisher_serie->name;
        $this->serie = $book->serie == null ? null : $book->serie->name;
        $this->authors = array_map(function($author){ return new AuthorToJsonAdapter($author); }, $book->authors->all());
        $this->oeuvreItems = array_map(function ($item) { return new OeuvreItemToJsonAdapter($item); }, $book->book_from_authors->all());
        $this->tags = array_map(function ($item) { return new TagToJsonAdapter($item); }, $book->tags->all());
        $this->onWishlist = $this->wishlistService->isBookInWishlistOfUser(Auth::user()->id, $book->id);

        if(!StringUtils::isEmpty($book->coverImage)){
            $baseUrl = URL::to('/');
            $this->image = $baseUrl . "/bookImages/" . $book->coverImage;
        }

        if($book->publication_date != null){
            $this->publicationDate = new DateToJsonAdapter($book->publication_date);
        }

        $personal_book_info = $this->personalBookInfoRepository->findByUserAndBook(Auth::user()->id, $book->id);
        if($personal_book_info != null){
            $this->personalBookInfo = new PersonalBookInfoToJsonAdapter($personal_book_info);
        }

        if($book->first_print_info != null){
            $this->firstPrintInfo = new FirstPrintToJsonAdapter($book->first_print_info);
        }
    }

    public function mapToJson(){
        $result = array(
            "id" => $this->id,
            "title" => $this->title,
            "subtitle" => $this->subtitle,
            "isbn" => $this->isbn,
            "genre" => $this->genre,
            "authors" => array_map(function($author){ return $author->mapToJson(); }, $this->authors),
            "tags" => array_map(function($tag){ return $tag->mapToJson(); }, $this->tags),
            "oeuvreItems" => array_map(function($item){ return $item->mapToJson(); }, $this->oeuvreItems),
            "publisher" => $this->publisher,
            "summary" => $this->summary,
            "country" => $this->country,
            "language" => $this->language,
            "retailPrice" => $this->retailPrice->mapToJson(),
            "pages" => $this->pages,
            "print" => $this->print,
            "translator" => $this->translator,
            "serie" => $this->serie,
            "publisherSerie" => $this->publisherSerie,
            "image" => $this->image,
            "onWishlist" => $this->onWishlist
        );

        if($this->publicationDate != null){
            $result['publicationDate'] = $this->publicationDate->mapToJson();
        }

        if($this->firstPrintInfo != null){
            $result['firstPrintInfo'] = $this->firstPrintInfo->mapToJson();
        }
        if($this->personalBookInfo != null){
            $result['personalBookInfo'] = $this->personalBookInfo->mapToJson();
        }

        return $result;
    }
}