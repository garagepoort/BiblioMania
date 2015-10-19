<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookController extends BaseController
{
    /** @var string $bookFolder*/
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
    /** @var  BookFilterManager */
    private $bookFilterHandler;


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
        $this->bookFilterHandler = App::make('BookFilterManager');
    }

    public function getBooks()
    {
        $bookId = Input::get('book_id');
        $scrollId = Input::get('scroll_id');

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'order_by_options' => $this->bookService->getOrderByValues(),
            'book_id' => $bookId,
            'scroll_id' => $scrollId
        ));
    }

    public function deleteBook(){
        try {
            $this->bookService->deleteBook(Input::get("bookId"));
        }catch (ServiceException $e){
            return ResponseCreator::createExceptionResponse($e);
        }
    }

    public function getFilters(){
        return $this->bookFilterHandler->getFiltersInJson();
    }

    public function getFullBook()
    {
        $book_id = Input::get('book_id');

        return $this->bookService->getFullBook($book_id);
    }

    public function filterBooks(){
        $filters = Input::get('filter');
        if(!is_array($filters)){
            $filters = array();
        }
        Session::put('book.filters', $filters);
        $filteredBooksResult = $this->bookService->filterBooks($filters);

        return $this->mapBooksToJson($filteredBooksResult);
    }

    public function searchBooks()
    {
        $query = Input::get('query');
        $operator = Input::get('operator');
        $type = Input::get('type');
        $read = Input::get('read');
        $owned = Input::get('owned');

        $book_id = Input::get('book_id');
        $orderBy = Input::get('order_by');

        $searchValues = new BookSearchValues($query, $operator, $type, $read, $owned);
        /** @var FilteredBooksResult $filteredBooksResult */
        $filteredBooksResult = $this->bookService->searchBooks($book_id, $searchValues, $orderBy);
        return $this->mapBooksToJson($filteredBooksResult);
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

    /**
     * @param $filteredBooksResult
     * @return array
     */
    public function mapBooksToJson($filteredBooksResult)
    {
        $jsonItems = array_map(function ($item) {
            return array(
                "id" => $item->id,
                "imageHeight" => $item->imageHeight,
                "imageWidth" => $item->imageWidth,
                "spritePointer" => $item->spritePointer,
                "coverImage" => $item->coverImage,
                "useSpriteImage" => $item->useSpriteImage,
                "hasWarnings" => !StringUtils::isEmpty($item->old_tags),
                "read" => $item->personal_book_info->read
            );
        }, $filteredBooksResult->getPaginatedItems()->getItems());

        $result = array(
            "total" => $filteredBooksResult->getPaginatedItems()->getTotal(),
            "last_page" => $filteredBooksResult->getPaginatedItems()->getLastPage(),
            "current_page" => $filteredBooksResult->getPaginatedItems()->getCurrentPage(),
            "data" => $jsonItems,
            "library_information" => array(
                "total_amount_books" => $filteredBooksResult->getTotalAmountOfBooks(),
                "total_amount_books_owned" => $filteredBooksResult->getTotalAmountOfBooksOwned(),
                "total_value" => $filteredBooksResult->getTotalValue(),
            )
        );
        return $result;
    }

}