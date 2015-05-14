<?php

class BookCreationService {
    /** @var  AuthorService */
    private $authorService;
    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var  BookService */
    private $bookService;
    /** @var  FirstPrintInfoService */
    private $firstPrintInfoService;
    /** @var  PersonalBookInfoService */
    private $personalBookInfoService;
    /** @var  BuyInfoService */
    private $buyInfoService;
    /** @var  GiftInfoService */
    private $giftInfoService;
    /** @var  OeuvreService */
    private $oeuvreService;

    function __construct()
    {
        $this->authorService = App::make('AuthorService');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->bookService = App::make('BookService');
        $this->firstPrintInfoService = App::make('FirstPrintInfoService');
        $this->personalBookInfoService = App::make('PersonalBookInfoService');
        $this->buyInfoService = App::make('BuyInfoService');
        $this->giftInfoService = App::make('GiftInfoService');
        $this->oeuvreService = App::make('OeuvreService');
    }


    public function createBook(BookCreationParameters $bookCreationParameters){
        DB::transaction(function() use ($bookCreationParameters)
        {
            $author = $this->authorService->createOrUpdate($bookCreationParameters->getAuthorInfoParameters());
            $this->oeuvreService->saveBookFromAuthors($bookCreationParameters->getAuthorInfoParameters()->getOeuvre(), $author->id);

            $book_publisher = $this->publisherService->findOrCreate(
                $bookCreationParameters->getBookInfoParameters()->getPublisherName(),
                $bookCreationParameters->getBookInfoParameters()->getCountryName()
            );

            $first_print_info = $this->firstPrintInfoService->findOrCreate($bookCreationParameters->getFirstPrintInfoParameters());
            $country = $this->countryService->findOrCreate($bookCreationParameters->getBookInfoParameters()->getCountryName());

            $book = $this->bookService->createBook($bookCreationParameters, $book_publisher, $country, $first_print_info);
            $book->authors()->sync(array($author->id => array('preferred' => true)));

            $personalBookInfo = $this->personalBookInfoService->findOrCreate($bookCreationParameters->getPersonalBookInfoParameters(), $book);

            if($bookCreationParameters->isBuyInfo()){
                $this->buyInfoService->findOrCreate($bookCreationParameters->getBuyInfoParameters(), $personalBookInfo);
            }else{
                $this->giftInfoService->findOrCreate($bookCreationParameters->getGiftInfoParameters(), $personalBookInfo);
            }
        });
    }
}