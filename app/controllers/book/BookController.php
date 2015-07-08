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


    public function __construct()
    {
        $this->bookService = App::make('BookService');
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

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'order_by_options' => $this->bookService->getOrderByValues(),
            'book_id' => $bookId,
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
        return $this->bookService->getFilteredBooks($book_id, $filterValues ,$orderBy);
    }

    public function getBooksFromSearch()
    {
        $criteria = Input::get('criteria');
        $books = $this->bookService->searchBooks($criteria);

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

    public function goToCreateBook()
    {
        return $this->goToEditOrCreate(true, null);
    }

    public function goToEditBook($id)
    {
        return $this->goToEditOrCreate(false, $id);
    }

    private function goToEditOrCreate($creating, $id){
        $covers = $this->bookService->getBookCoverTypes();
        $states = $this->bookService->getBookStates();
        $genres = Genre::where('parent_id', '=', null)->get();
        if($creating){
            $withArray = BookFormFiller::createArrayForCreate();
        }else{
            $withArray = BookFormFiller::createEditBookArray($id);
        }
        $withArray['title'] = 'Boek toevoegen';
        $withArray['languages'] = $this->languageService->getLanguagesMap();
        $withArray['covers'] = $covers;
        $withArray['states'] = $states;
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());
        $withArray['tags_json'] = json_encode(Tag::all());
        $withArray['series_json'] = json_encode(Serie::all());
        $withArray['publisher_series_json'] = json_encode(PublisherSerie::all());
        return View::make($this->bookFolder . 'createBook')->with($withArray);
    }

    public function createOrEditBook()
    {
        $validator = $this->bookFormValidator->createValidator();

        if ($validator->fails()) {

            if (Input::get('book_id') != '') {
                $book_id = Input::get('book_id');
                return Redirect::to('/editBook/' . $book_id)->withErrors($validator)->withInput();
            }
            return Redirect::to('/createBook')->withErrors($validator)->withInput();

        } else {

            $buyInfoParameters = null;
            $giftInfoParameters = null;

            if (Input::get('buyOrGift') == 'BUY') {
                $buyInfoParameters = $this->buyInfoParameterMapper->create();
            } else {
                $giftInfoParameters = $this->giftInfoParameterMapper->create();
            }

            $authorParameters = array($this->authorInfoParameterMapper->create());
            $authorParameters = array_merge($authorParameters, $this->authorInfoParameterMapper->createSecondaryAuthors());

            $bookCreationParameters = new BookCreationParameters(
                $this->bookInfoParameterMapper->create(),
                $this->extraBookInfoParameterMapper->create(),
                $authorParameters,
                $buyInfoParameters,
                $giftInfoParameters,
                $this->coverInfoParameterMapper->create(),
                $this->firstPrintInfoParameterMapper->create(),
                $this->personalBookInfoParameterMapper->create()
                );

            $this->bookCreationService->createBook($bookCreationParameters);
            return Redirect::to('/getBooks');
        }
    }

}