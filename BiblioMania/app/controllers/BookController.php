<?php

class BookController extends BaseController
{

    private $bookFolder = "book/";

    protected $publisherService;
    protected $buyInfoService;
    protected $giftInfoService;
    protected $countryService;

    public function __construct(PublisherService $publisherService,
                                BuyInfoService $buyInfoService,
                                GiftInfoService $giftInfoService,
                                CountryService $countryService)
    {
        $this->publisherService = $publisherService;
        $this->buyInfoService = $buyInfoService;
        $this->giftInfoService = $giftInfoService;
        $this->countryService = $countryService;
    }

    public function getBooks()
    {
        $bookId = Input::get('book_id');

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'order_by_options' => App::make('BookService')->getOrderByValues(),
            'book_id' => $bookId,
            'total_value_library' => App::make('BookService')->getValueOfLibrary(),
            'total_amount_of_books' => App::make('BookService')->getTotalAmountOfBooksInLibrary(),
            'total_amount_of_books_owned' => App::make('BookService')->getTotalAmountOfBooksOwned(),
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

        return App::make('BookService')->getFilteredBooks($book_id, $book_title, $book_subtitle, $book_author_name, $book_author_firstname, $orderBy);
    }

    public function getBooksFromSearch()
    {
        $criteria = Input::get('criteria');
        $books = Book::with(array(
            'authors' => function ($query) {
                $query->orderBy('name', 'DESC');
            },
            'publisher',
            'genre',
            'personal_book_info',
            'first_print_info',
            'publication_date',
            'country',
            'publisher_serie',
            'serie'))
            ->where('user_id', '=', Auth::user()->id)
            ->where(function ($query) use ($criteria) {
                $query->where('title', 'LIKE', '%' . $criteria . '%')
                    ->orWhere('subtitle', 'LIKE', '%' . $criteria . '%');
            })
            ->orderBy('title')
            ->paginate(60);

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'books' => $books,
            'books_json' => $books->toJson(),
            'total_value_library' => App::make('BookService')->getValueOfLibrary(),
            'total_amount_of_books' => App::make('BookService')->getTotalAmountOfBooksInLibrary(),
            'total_amount_of_books_owned' => App::make('BookService')->getTotalAmountOfBooksOwned(),
            'bookFilters' => BookFilter::getFilters()
        ));
    }

    public function goToCreateBook()
    {
        $covers = array("Hard cover"=>"Hard cover", "Paperback"=>"Paperback", "Dwarsligger"=>"Dwarsligger", "E-book"=>"E-book", "Luisterboek"=>"Luisterboek");
        $genres = Genre::where('parent_id', '=', null)->get();

        $withArray = $this->createEmptyBookArray();
        $withArray['title'] = 'Boek toevoegen';
        $withArray['languages'] = App::make('LanguageService')->getLanguagesMap();
        $withArray['covers'] = $covers;
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode(App::make('CountryService')->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());

        return View::make($this->bookFolder . 'createBook')->with($withArray);
    }

    public function goToEditBook($id)
    {
        $covers = array("Hard cover"=>"Hard cover", "Paperback"=>"Paperback", "Dwarsligger"=>"Dwarsligger", "E-book"=>"E-book", "Luisterboek"=>"Luisterboek");
        $genres = Genre::where('parent_id', '=', null)->get();

        $withArray = $this->createEditBookArray($id);
        $withArray['title'] = 'Boek toevoegen';
        $withArray['languages'] = App::make('LanguageService')->getLanguagesMap();
        $withArray['covers'] = $covers;
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode(App::make('CountryService')->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());

        return View::make($this->bookFolder . 'createBook')->with($withArray);
    }

    public function createOrEditBook()
    {
        $validator = BookFormValidator::createValidatorForBookForm();

        if ($validator->fails()) {
            if (Input::get('book_id') != '') {
                $book_id = Input::get('book_id');
                return Redirect::to('/editBook/' . $book_id)->withErrors($validator)->withInput();
            }
            return Redirect::to('/createBook')->withErrors($validator)->withInput();
        } else {

            $publisher_country = $this->countryService->findOrSave(Input::get('book_country'));
            $book_publisher = $this->publisherService->saveOrUpdate(Input::get('book_publisher'), $publisher_country);

            $book_author_date_of_birth_id = $this->createDate(Input::get('author_date_of_birth_day'), Input::get('author_date_of_birth_month'), Input::get('author_date_of_birth_year'));
            $book_author_date_of_death_id = $this->createDate(Input::get('author_date_of_death_day'), Input::get('author_date_of_death_month'), Input::get('author_date_of_death_year'));

            $authorImage = null;
            if (Input::get('authorImageSelfUpload')) {
                $authorImage = $this->checkCoverImage('author_image');
            } else {
                if(Input::get('authorImageUrl') != ''){
                    $authorImage = App::make('ImageService')->getImageFromUrl(Input::get('authorImageUrl'), Input::get('author_name'));
                }
            }
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
                $this->buyInfoService->save($personal_book_info->id,
                    DateTime::createFromFormat('d/m/Y', Input::get('buy_info_buy_date')),
                    Input::get('buy_info_price_payed'),
                    Input::get('buy_info_recommended_by'),
                    Input::get('buy_info_shop'),
                    Input::get('buy_info_city'),
                    $this->countryService->findOrSave(Input::get('buy_info_country'))->id);
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

    private function createBook($book_author_model, $book_publisher, $publisher_country, $book_from_author_id, $first_print_info)
    {
        $publisherSerieService = App::make('PublisherSerieService');
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
            $book->coverImage = $this->checkCoverImage('book_cover_image');
        } else {
            if(Input::get('coverInfoUrl') != ''){
                $book->coverImage = App::make('ImageService')->getImageFromUrl(Input::get('coverInfoUrl'), Input::get('book_title'));
            }
        }


        $book->title = Input::get("book_title");
        $book->subtitle = Input::get("book_subtitle");
        $book->ISBN = Input::get("book_isbn");
        $book->number_of_pages = Input::get("book_number_of_pages");
        $book->print = Input::get("book_print");
        $book->genre_id = Input::get('book_genre');
        $book->type_of_cover = Input::get('book_type_of_cover');
        $book->publication_date_id = App::make('DateService')->createDate(Input::get('book_publication_date_day'),
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
        $firstPrintInfoService = App::make('FirstPrintInfoService');

        $country = App::make('CountryService')->findOrSave(Input::get('first_print_country'));

        $first_print_publication_date = App::make('DateService')->createDate(
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

    private function createPersonalBookInfo($book)
    {
        $string_reading_dates = explode(",", Input::get('personal_info_reading_dates'));
        $reading_dates = array();
        foreach ($string_reading_dates as $string_reading_date) {
            if($string_reading_date != null){
                array_push($reading_dates, DateTime::createFromFormat('d/m/Y', $string_reading_date));
            }
        }

        $personal_book_info = App::make('PersonalBookInfoService')->save($book->id,
            Input::get('personal_info_owned'),
            Input::get('personal_info_reason_not_owned'),
            Input::get('personal_info_review'),
            Input::get('personal_info_rating'),
            Input::get('personal_info_retail_price'),
            $reading_dates);

        return $personal_book_info;
    }

    private function checkCoverImage($image)
    {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

        $coverImage = null;
        $logger->info("Checking cover file...");
        if (Input::hasFile($image)) {
            $logger->info("Input file for cover image found. Uploading cover image");
            $file = Input::file($image);

            $userUsername = Auth::user()->username;
            $destinationPath = 'bookImages/' . $userUsername;

            $filename = $file->getClientOriginalName();
            $filename = str_random(8) . '_' . $filename;
            $upload_success = Input::file($image)->move($destinationPath, $filename);

            if ($upload_success == false) {
                $logger->info("Uploading of coverImage failed!!");
                return Redirect::to('/createBook')->withErrors(array('book_cover_image' => 'Cover image could not be uploaded'))->withInput();
            }
            $coverImage = $destinationPath . '/' . $filename;
        } else {
            $coverImage = 'images/questionCover.png';
        }

        return $coverImage;
    }

    private function createEmptyBookArray()
    {
        $result = array();
        $result['book_id'] = '';
        $result['book_title'] = 'Nieuw boek';
        $result['book_subtitle'] = '';
        $result['book_isbn'] = '';
        $result['book_number_of_pages'] = '';
        $result['book_print'] = '';
        $result['book_cover_image'] = '';
        $result['author_name_book_info'] = '';
        $result['author_name'] = '';
        $result['author_infix'] = '';
        $result['author_firstname'] = '';
        $result['author_image'] = '';
        $result['book_publisher'] = '';
        $result['book_country'] = '';
        $result['book_serie'] = '';
        $result['book_publisher_serie'] = '';
        $result['book_languageId'] = '';
        $result['book_genre_input'] = '';
        $result['book_publication_date_day'] = '';
        $result['book_publication_date_month'] = '';
        $result['book_publication_date_year'] = '';
        $result['author_date_of_birth_day'] = '';
        $result['author_date_of_birth_month'] = '';
        $result['author_date_of_birth_year'] = '';
        $result['author_date_of_death_day'] = '';
        $result['author_date_of_death_month'] = '';
        $result['author_date_of_death_year'] = '';
        $result['first_print_title'] = '';
        $result['first_print_subtitle'] = '';
        $result['first_print_isbn'] = '';
        $result['first_print_country'] = '';
        $result['first_print_publisher'] = '';
        $result['first_print_publication_date_day'] = '';
        $result['first_print_publication_date_month'] = '';
        $result['first_print_publication_date_year'] = '';
        $result['personal_info_owned'] = 'true';
        $result['personal_info_reading_date_input'] = '';
        $result['personal_info_rating'] = '';
        $result['gift_info_receipt_date'] = '';
        $result['gift_book_info_retail_price'] = '';
        $result['gift_info_from'] = '';
        $result['gift_info_occasion'] = '';
        $result['buy_info_buy_date'] = '';
        $result['buy_info_price_payed'] = '';
        $result['buy_book_info_retail_price'] = '';
        $result['buy_info_recommended_by'] = '';
        $result['buy_info_shop'] = '';
        $result['buy_info_city'] = '';
        $result['buy_info_country'] = '';
        $result['book_type_of_cover'] = '';
        $result['giftInfoSet'] = false;
        $result['buyInfoSet'] = true;
        $result['book_from_author_title'] = '';
        return $result;
    }

    private function createEditBookArray($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author'))->find($bookId);
        $author = Author::with(array('date_of_birth', 'date_of_death'))->find($book->authors->first()->id);

        $result = $this->createEmptyBookArray();
        $result['book_id'] = $bookId;
        $result['book_title'] = $book->title;
        $result['book_subtitle'] = $book->subtitle;
        $result['book_isbn'] = $book->ISBN;
        $result['book_number_of_pages'] = $book->number_of_pages;
        $result['book_print'] = $book->print;
        $result['book_cover_image'] = $book->coverImage;
        $result['book_type_of_cover'] = $book->type_of_cover;

        $result['first_print_title'] = $book->first_print_info->title;
        $result['first_print_subtitle'] = $book->first_print_info->subtitle;
        $result['first_print_isbn'] = $book->first_print_info->ISBN;

        if ($book->first_print_info->country != null) {
            $result['first_print_country'] = $book->first_print_info->country->name;
        }

        if ($book->first_print_info->publisher != null) {
            $result['first_print_publisher'] = $book->first_print_info->publisher->name;
        }

        if ($book->first_print_info->publication_date != null) {
            $result['first_print_publication_date_day'] = $book->first_print_info->publication_date->day;
            $result['first_print_publication_date_month'] = $book->first_print_info->publication_date->month;
            $result['first_print_publication_date_year'] = $book->first_print_info->publication_date->year;
        }

        if ($book->personal_book_info != null) {
            $result['personal_info_owned'] = $book->personal_book_info->get_owned();
            $resultDates = '';
            if (count($book->personal_book_info->reading_dates) > 0) {
                foreach ($book->personal_book_info->reading_dates as $reading_date) {
                    $time = strtotime($reading_date->date);
                    $myFormatForView = date("d/m/Y", $time);
                    $resultDates = $resultDates . $myFormatForView . ',';
                }
            }
            $resultDates = rtrim($resultDates, ",");
            $result['personal_info_reading_date_input'] = $resultDates;
            $result['personal_info_rating'] = $book->personal_book_info->rating;
        }

        $result['author_name'] = $book->authors[0]->name;
        $result['author_infix'] = $book->authors[0]->infix;
        $result['author_firstname'] = $book->authors[0]->firstname;
        $result['author_image'] = $book->authors[0]->image;

        if(empty($book->authors[0]->infix)){
            $result['author_name_book_info'] = $book->authors[0]->name . ', ' . $book->authors[0]->firstname;
        }else{
            $result['author_name_book_info'] = $book->authors[0]->name . ', ' . $book->authors[0]->infix . ', ' . $book->authors[0]->firstname;
        }

        if ($book->publisher != null) {
            $result['book_publisher'] = $book->publisher->name;
        }

        if ($book->country != null) {
            $result['book_country'] = $book->country->name;
        }

        if ($book->serie != null) {
            $result['book_serie'] = $book->serie->name;
        }

        if ($book->publisher_serie != null) {
            $result['book_publisher_serie'] = $book->publisher_serie->name;
        }

        if ($book->language != null) {
            $result['book_languageId'] = $book->language->id;
        } else {
            $result['book_languageId'] = '';
        }

        if ($book->genre != null) {
            $result['book_genre_input'] = $book->genre->id;
        }

        if ($book->publication_date != null) {
            $result['book_publication_date_day'] = $book->publication_date->day;
            $result['book_publication_date_month'] = $book->publication_date->month;
            $result['book_publication_date_year'] = $book->publication_date->year;
        }

        if ($author->date_of_birth != null) {
            $result['author_date_of_birth_day'] = $author->date_of_birth->day;
            $result['author_date_of_birth_month'] = $author->date_of_birth->month;
            $result['author_date_of_birth_year'] = $author->date_of_birth->year;
        }

        if ($author->date_of_death != null) {
            $result['author_date_of_death_day'] = $author->date_of_death->day;
            $result['author_date_of_death_month'] = $author->date_of_death->month;
            $result['author_date_of_death_year'] = $author->date_of_death->year;
        }

        if ($book->personal_book_info->buy_info != null) {
            $time = strtotime($book->personal_book_info->buy_info->buy_date);
            $myFormatForView = date("d/m/Y", $time);
            $result['buy_info_buy_date'] = $myFormatForView;
            $result['buy_info_price_payed'] = $book->personal_book_info->buy_info->price_payed;
            $result['buy_book_info_retail_price'] = $book->retail_price;
            $result['buy_info_recommended_by'] = $book->personal_book_info->buy_info->recommended_by;
            $result['buy_info_shop'] = $book->personal_book_info->buy_info->shop;
            if ($book->personal_book_info->buy_info->city != null) {
                $result['buy_info_city'] = $book->personal_book_info->buy_info->city->name;
            }
            if ($book->personal_book_info->buy_info->country != null) {
                $result['buy_info_country'] = $book->personal_book_info->buy_info->country->name;
            }
            $result['buyInfoSet'] =true;
            $result['giftInfoSet'] =false;
        }

        if ($book->personal_book_info->gift_info != null) {
            $time = strtotime($book->personal_book_info->gift_info->receipt_date);
            $myFormatForView = date("d/m/Y", $time);
            $result['gift_info_receipt_date'] = $myFormatForView;
            $result['gift_book_info_retail_price'] = $book->retail_price;
            $result['gift_info_from'] = $book->personal_book_info->gift_info->from;
            $result['gift_info_occasion'] = $book->personal_book_info->gift_info->occasion;
            $result['giftInfoSet'] = true;
            $result['buyInfoSet'] = false;
        }

        if($book->book_from_author != null){
            $result['book_from_author_title'] = $book->book_from_author->title;
        }

        return $result;
    }

    private function createDate($author_date_day, $author_date_month, $author_date_year)
    {
        if (!empty($author_date_day) && !empty($author_date_month) && !empty($author_date_year)) {
            return App::make('DateService')->createDate($author_date_day,
                $author_date_month,
                $author_date_year)->id;
        }

        return null;
    }


}