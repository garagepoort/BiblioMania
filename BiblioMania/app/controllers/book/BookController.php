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

    public function getNextBooks()
    {
        $book_title = Input::get('bookTitle');
        $book_subtitle = Input::get('book_subtitle');
        $book_id = Input::get('book_id');
        $book_author_name = Input::get('book_author_name');
        $book_author_firstname = Input::get('book_author_firstname');
        $orderBy = Input::get('order_by');

        return $this->bookService->getFilteredBooks($book_id, $book_title, $book_subtitle, $book_author_name, $book_author_firstname, $orderBy);
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
        $covers = array("Hard cover" => "Hard cover", "Paperback" => "Paperback", "Dwarsligger" => "Dwarsligger", "E-book" => "E-book", "Luisterboek" => "Luisterboek");
        $genres = Genre::where('parent_id', '=', null)->get();

        $withArray = BookFormFiller::createArrayForCreate();
        $withArray['title'] = 'Boek toevoegen';
        $withArray['languages'] = App::make('LanguageService')->getLanguagesMap();
        $withArray['covers'] = $covers;
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());

        return View::make($this->bookFolder . 'createBook')->with($withArray);
    }

    public function goToEditBook($id)
    {
        $covers = array("Hard cover" => "Hard cover", "Paperback" => "Paperback", "Dwarsligger" => "Dwarsligger", "E-book" => "E-book", "Luisterboek" => "Luisterboek");
        $genres = Genre::where('parent_id', '=', null)->get();

        $withArray = BookFormFiller::createEditBookArray($id);
        $withArray['title'] = 'Boek toevoegen';
        $withArray['languages'] = App::make('LanguageService')->getLanguagesMap();
        $withArray['covers'] = $covers;
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());

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

            $bookCreationParameters = new BookCreationParameters(
                $this->bookInfoParameterMapper->create(),
                $this->extraBookInfoParameterMapper->create(),
                $this->authorInfoParameterMapper->create(),
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