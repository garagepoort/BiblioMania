<?php

class BookController extends BaseController
{
    private $bookFolder = "book/";

    protected $publisherService;
    protected $buyInfoService;
    protected $giftInfoService;
    protected $countryService;
    protected $bookService;
    protected $dateService;
    protected $authorService;
    protected $imageService;
    protected $bookFormValidator;

    public function __construct(PublisherService $publisherService,
                                BuyInfoService $buyInfoService,
                                GiftInfoService $giftInfoService,
                                CountryService $countryService,
                                BookService $bookService,
                                DateService $dateService,
                                ImageService $imageService,
                                BookFormValidator $bookFormValidator,
                                AuthorService $authorService)
    {
        $this->publisherService = $publisherService;
        $this->buyInfoService = $buyInfoService;
        $this->giftInfoService = $giftInfoService;
        $this->countryService = $countryService;
        $this->bookService = $bookService;
        $this->dateService = $dateService;
        $this->imageService = $imageService;
        $this->bookFormValidator = $bookFormValidator;
        $this->authorService = $authorService;
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

            $publisher_country = $this->countryService->findOrCreate(Input::get('book_country'));
            $book_publisher = $this->publisherService->findOrCreate(Input::get('book_publisher'));
            $book_publisher->countries()->attach($publisher_country);


            $book_author_date_of_birth = $this->createDate(Input::get('author_date_of_birth_day'), Input::get('author_date_of_birth_month'), Input::get('author_date_of_birth_year'));
            $book_author_date_of_death = $this->createDate(Input::get('author_date_of_death_day'), Input::get('author_date_of_death_month'), Input::get('author_date_of_death_year'));

            $authorImage = null;
            if (Input::get('authorImageSelfUpload')) {
                $authorImage = ImageUploader::uploadImage('author_image');
            } else {
                if (Input::get('authorImageUrl') != '') {
                    $authorImage = $this->imageService->getImageFromUrl(Input::get('authorImageUrl'), Input::get('author_name'));
                }
            }

            $this->authorService->create()
            $book_author_model = App::make('AuthorService')->saveorUpdate(
                Input::get('author_name'),
                Input::get('author_infix'),
                Input::get('author_firstname'),
                $authorImage,
                null,
                $book_author_date_of_birth_id,
                $book_author_date_of_death_id);

            $book_from_author_id = $this->createBookFromAuthorLink($book_author_model->id);
            $first_print_info = $this->createFirstPrintInfo();

            $book = $this->createBook($book_author_model, $book_publisher, $publisher_country, $book_from_author_id, $first_print_info);

            $personal_book_info = $this->createPersonalBookInfo($book);

            if (Input::get('buyOrGift') == 'BUY') {
                $this->giftInfoService->delete($personal_book_info->id);
                $buy_date = DateTime::createFromFormat('d/m/Y', Input::get('buy_info_buy_date'));
                if($buy_date == false){
                    $buy_date = null;
                }
                $this->buyInfoService->save($personal_book_info->id,
                    $buy_date,
                    Input::get('buy_info_price_payed'),
                    Input::get('buy_info_recommended_by'),
                    Input::get('buy_info_shop'),
                    Input::get('buy_info_city'),
                    $this->countryService->findOrCreate(Input::get('buy_info_country'))->id);
            } else {
                $this->giftInfoService->save(
                    $personal_book_info->id,
                    Input::get('gift_info_receipt_date'),
                    Input::get('gift_info_from'),
                    Input::get('gift_info_occasion'));
            }
            return Redirect::to('/getBooks');
        }
    }

    private function createDate($author_date_day, $author_date_month, $author_date_year)
    {
        if (!empty($author_date_day) && !empty($author_date_month) && !empty($author_date_year)) {
            return $this->dateService->createDate($author_date_day,
                $author_date_month,
                $author_date_year);
        }

        return null;
    }

    private function createBookFromAuthorLink($author_id)
    {
        $bookFromAuthorTitle = Input::get('bookFromAuthorTitle');

        App::make('OeuvreService')->linkNewOeuvreFromAuthor($author_id, Input::get('oeuvre'));

        $bookFromAuthorToBeLinked = BookFromAuthor::where('title', '=', $bookFromAuthorTitle)
            ->where('author_id', '=', $author_id)
            ->first();

        if ($bookFromAuthorToBeLinked != null) {
            return $bookFromAuthorToBeLinked->id;
        }
        return null;
    }

    private function createFirstPrintInfo()
    {
        /** @var FirstPrintInfoService $firstPrintInfoService */
        $firstPrintInfoService = App::make('FirstPrintInfoService');

        $country = $this->countryService->findOrCreate(Input::get('first_print_country'));

        $first_print_publication_date = $this->dateService->createDate(
            Input::get('first_print_publication_date_day'),
            Input::get('first_print_publication_date_month'),
            Input::get('first_print_publication_date_year'));

        $first_print = $firstPrintInfoService->saveOrUpdate(
            Input::get("first_print_title"),
            Input::get("first_print_subtitle"),
            Input::get("first_print_isbn"),
            $first_print_publication_date,
            Input::get('first_print_publisher'),
            $country->id,
            Input::get('first_print_languageId'));

        return $first_print;
    }

    private function createBook($book_author_model, $book_publisher, $publisher_country, $book_from_author_id, $first_print_info)
    {
        /** @var PublisherSerieService $publisherSerieService */
        $publisherSerieService = App::make('PublisherSerieService');
        /** @var BookSerieService $bookSerieService */
        $bookSerieService = App::make('BookSerieService');

        $book = new Book();
        if (Input::get('book_id') != '') {
            $book = Book::find(Input::get('book_id'));
        }

        if (Input::get('buyOrGift') == 'BUY') {
            $book_info_retail_price = Input::get('buy_book_info_retail_price');
        } else {
            $book_info_retail_price = Input::get('gift_book_info_retail_price');
        }

        if (Input::get('coverInfoSelfUpload')) {
            $book->coverImage = ImageUploader::uploadImage('book_cover_image');
        } else {
            if (Input::get('coverInfoUrl') != '') {
                $book->coverImage = $this->imageService->getImageFromUrl(Input::get('coverInfoUrl'), Input::get('book_title'));
            }
        }

        $book->title = Input::get("book_title");
        $book->subtitle = Input::get("book_subtitle");
        $book->ISBN = Input::get("book_isbn");
        $book->number_of_pages = Input::get("book_number_of_pages");
        $book->print = Input::get("book_print");
        $book->genre_id = Input::get('book_genre');
        $book->type_of_cover = Input::get('book_type_of_cover');
        $book->publication_date_id = $this->dateService->createDate(Input::get('book_publication_date_day'),
            Input::get('book_publication_date_month'),
            Input::get('book_publication_date_year'))->id;
        $book->publisher_id = $book_publisher->id;
        $book->publisher_country_id = $publisher_country->id;
        $book->publisher_serie_id = $publisherSerieService->findOrSave(Input::get('book_publisher_serie'), $book_publisher->id)->id;
        $book->language_id = Input::get('book_languageId');
        $book->serie_id = $bookSerieService->findOrSave(Input::get('book_serie'))->id;
        $book->user_id = Auth::user()->id;
        $book->first_print_info_id = $first_print_info->id;
        $book->retail_price = $book_info_retail_price;
        $book->book_from_author_id = $book_from_author_id;
        $book->save();
        $book->authors()->sync(array($book_author_model->id => array('preferred' => true)));
        return $book;
    }

    private function createPersonalBookInfo($book)
    {
        $string_reading_dates = explode(",", Input::get('personal_info_reading_dates'));
        $reading_dates = array();
        foreach ($string_reading_dates as $string_reading_date) {
            if ($string_reading_date != null) {
                array_push($reading_dates, DateTime::createFromFormat('d/m/Y', $string_reading_date));
            }
        }
        /** @var PersonalBookInfoService $personalBookInfoService */
        $personalBookInfoService = App::make('PersonalBookInfoService');
        $personal_book_info = $personalBookInfoService->save($book->id,
            Input::get('personal_info_owned'),
            Input::get('personal_info_reason_not_owned'),
            Input::get('personal_info_review'),
            Input::get('personal_info_rating'),
            Input::get('personal_info_retail_price'),
            $reading_dates);

        return $personal_book_info;
    }


}