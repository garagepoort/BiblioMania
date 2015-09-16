<?php

class BookController extends BaseController
{
    private $bookFolder = "book/";

    /** @var  BookService */
    private $bookService;
    /** @var  BookFormValidator */
    private $bookFormValidator;
    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  AuthorInfoParameterMapper */
    private $authorInfoParameterMapper;
    /** @var  ExtraBookInfoParameterMapper */
    private $extraBookInfoParameterMapper;
    /** @var  BookInfoParameterMapper */
    private $bookInfoParameterMapper;
    /** @var  BuyInfoParameterMapper */
    private $buyInfoParameterMapper;
    /** @var  GiftInfoParameterMapper */
    private $giftInfoParameterMapper;
    /** @var  CoverInfoParameterMapper */
    private $coverInfoParameterMapper;
    /** @var  FirstPrintInfoParameterMapper */
    private $firstPrintInfoParameterMapper;
    /** @var  PersonalBookInfoParameterMapper */
    private $personalBookInfoParameterMapper;
    /** @var  CountryService */
    private $countryService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  CurrencyService */
    private $currencyService;


    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->currencyService = App::make('CurrencyService');
        $this->bookFormValidator = App::make('BookFormValidator');
        $this->bookCreationService = App::make('BookCreationService');
        $this->authorInfoParameterMapper = App::make('AuthorInfoParameterMapper');
        $this->extraBookInfoParameterMapper = App::make('ExtraBookInfoParameterMapper');
        $this->bookInfoParameterMapper = App::make('BookInfoParameterMapper');
        $this->buyInfoParameterMapper = App::make('BuyInfoParameterMapper');
        $this->giftInfoParameterMapper = App::make('GiftInfoParameterMapper');
        $this->coverInfoParameterMapper = App::make('CoverInfoParameterMapper');
        $this->firstPrintInfoParameterMapper = App::make('FirstPrintInfoParameterMapper');
        $this->personalBookInfoParameterMapper = App::make('PersonalBookInfoParameterMapper');
        $this->countryService = App::make('CountryService');
        $this->languageService = App::make('LanguageService');
    }

    public function getBooks()
    {
        $bookId = Input::get('book_id');
        $scrollId = Input::get('scroll_id');

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'order_by_options' => $this->bookService->getOrderByValues(),
            'book_id' => $bookId,
            'scroll_id' => $scrollId,
            'total_value_library' => $this->bookService->getValueOfLibrary(),
            'total_amount_of_books' => $this->bookService->getTotalAmountOfBooksInLibrary(),
            'total_amount_of_books_owned' => $this->bookService->getTotalAmountOfBooksOwned(),
            'bookFilters' => BookFilter::getFilters()
        ));
    }

    public function getFullBook()
    {
        $book_id = Input::get('book_id');

        return $this->bookService->getFullBook($book_id);
    }

    public function getNextBooks()
    {
        $query = Input::get('query');
        $operator = Input::get('operator');
        $type = Input::get('type');
        $read = Input::get('read');
        $owned = Input::get('owned');

        $book_id = Input::get('book_id');
        $orderBy = Input::get('order_by');

        $filterValues = new BookFilterValues($query, $operator, $type, $read, $owned);
        $filteredBooks = $this->bookService->getFilteredBooks($book_id, $filterValues, $orderBy);
        $jsonItems = array_map(function($item){
            return array(
                "id"=>$item->id,
                "imageHeight"=>$item->imageHeight,
                "imageWidth"=>$item->imageWidth,
                "spritePointer"=>$item->spritePointer,
                "coverImage"=>$item->coverImage,
                "useSpriteImage"=>$item->useSpriteImage,
            );
        }, $filteredBooks->getItems());

        $result =array(
            "total"=>$filteredBooks->getTotal(),
            "last_page"=>$filteredBooks->getLastPage(),
            "current_page"=>$filteredBooks->getCurrentPage(),
            "data"=>$jsonItems
        );
        return $result;
    }

    public function getBooksList(){
        $books = $this->bookService->getCompletedBooksForList();
        return View::make($this->bookFolder . 'booksList')->with(array(
            'title' => 'Boeken',
            'books' => $books
        ));
    }

    public function getDraftBooksList(){
        $books = $this->bookService->getDraftBooksForList();
        return View::make($this->bookFolder . 'draftBooksList')->with(array(
            'title' => 'Boeken',
            'books' => $books
        ));
    }

    public function getBooksFromSearch()
    {
        $criteria = Input::get('criteria');
        $books = $this->bookService->searchCompletedBooks($criteria);

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'books' => $books,
            'books_json' => $books->toJson(),
            'total_value_library' => $this->bookService->getValueOfLibrary(),
            'total_amount_of_books' => $this->bookService->getTotalAmountOfBooksInLibrary(),
            'total_amount_of_books_owned' => $this->bookService->getTotalAmountOfBooksOwned(),
            'bookFilters' => BookFilter::getFilters()
        ));
    }

}