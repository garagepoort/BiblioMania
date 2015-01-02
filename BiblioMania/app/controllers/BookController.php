<?php

class BookController extends BaseController {

	private $bookFolder = "book/";

    private function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    }

	public function getBooks($id = null)
	{
        $with = array(
                'authors' => function($query) {
                    $query->orderBy('name', 'DESC');
                },
                'publisher', 
                'genre', 
                'personal_book_info', 
                'first_print_info',
                'publication_date', 
                'country',
                'publisher_serie', 
                'serie');
        if($id==null){
            $books = Book::with($with)
            ->paginate(60);
        }else{
            $books = Book::with($with)
            ->where('id', '=', $id)->paginate(60);
        }

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

    public function getNextBooks(){
        $with = array(
                'authors' => function($query) {
                    $query->orderBy('name', 'DESC');
                },
                'publisher', 
                'genre', 
                'personal_book_info', 
                'first_print_info',
                'publication_date', 
                'country',
                'publisher_serie', 
                'serie');
        $books = Book::with($with)->paginate(60);
        return $books->toJson();
    }

    public function getBooksFromSearch(){
        $criteria = Input::get('criteria');
        $books = Book::with(array(
                    'authors' => function($query) {
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
                ->where('user_id' , '=', Auth::user()->id)
                ->where(function ($query) use ($criteria){
                     $query->where('title', 'LIKE', '%'.$criteria.'%')
                    ->orWhere('subtitle', 'LIKE', '%'.$criteria.'%');
                })
                ->orderBy('title')
                ->paginate(60);

        // $books = Book::where('user_id' , '=', Auth::user()->id)->get();
        // $filteredBooks = $books->filter(function($book){
        //     if($book->) 
        // });

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

    public function getJsonBook($book_id){
        return Book::find($book_id);
    }

	public function goToCreateBook()
	{
        $dateService = App::make('DateService');
		$covers = array("Hard cover", "Soft cover", "Other");
        $genres = Genre::where('parent_id' , '=', null)->get();

		return View::make($this->bookFolder . 'createBook')->with(array(
			'title' => 'Boek toevoegen',
            'languages' => App::make('LanguageService')->getLanguages(),
            'covers' => $covers,
            'genres' => $genres,
			'countries_json' => json_encode(App::make('CountryService')->getCountries()),
            'authors_json' => json_encode(Author::with('oeuvre')->get(['id','name', 'firstname', 'infix'])),
            'publishers_json' => json_encode(Publisher::all())
			));
	}

	public function createBook(){

		$rules = array(
            'book_title' => 'required',
            'book_author' => 'required',
            'book_isbn' => 'required|numeric|digits:13',
            'book_number_of_pages' => 'numeric',
            'book_print' => 'numeric',
            'book_publisher' => 'required',
            'book_genre' => 'required',
            'author_name' => 'required',
            'author_firstname' => 'required',
            'author_date_of_birth' => 'date_format:"d/m/Y"',
            'author_date_of_death' => 'date_format:"d/m/Y"',

            'first_print_isbn' => 'numeric|digits:13',
            'first_print_publication_date' => 'date_format:"d/m/Y"'
        );
        $validator = Validator::make(Input::get(), $rules);
        
        if($validator->fails()){
            return Redirect::to('/createBook')->withErrors($validator)->withInput();
        }else{
            $authorService = App::make('AuthorService');
            $publisherService = App::make('PublisherService');
            $publisherSerieService = App::make('PublisherSerieService');
            $bookSerieService = App::make('BookSerieService');
            $buyInfoService = App::make('BuyInfoService');
            $giftInfoService = App::make('GiftInfoService');
            $countryService = App::make('CountryService');

            $book_cover_image_file = $this->checkCoverImage();

            //BOOK INPUT
            $book_title = Input::get("book_title");
            $book_subtitle = Input::get("book_subtitle");
            $book_isbn = Input::get("book_isbn");
            $book_number_of_pages = Input::get("book_number_of_pages");
            $book_print = Input::get("book_print");
            $book_country = Input::get('book_country');
            $book_language = Input::get('book_languageId');
            $book_publication_date_day = Input::get('book_publication_date_day');
            $book_publication_date_month = Input::get('book_publication_date_month');
            $book_publication_date_year = Input::get('book_publication_date_year');
            $book_genre_id = Input::get('book_genre');
            $book_type_of_cover = Input::get('book_type_of_cover');
            $book_publisher_name = Input::get('book_publisher');
            $book_publisher_serie = Input::get('book_publisher_serie');
            $book_serie = Input::get('book_serie');


            //AUTHOR INPUT
            $book_author_name = Input::get('author_name');
            $book_author_firstname = Input::get('author_firstname');
            $book_author_date_of_birth = DateTime::createFromFormat('d/m/Y', Input::get('author_date_of_birth'));
            $book_author_date_of_death = DateTime::createFromFormat('d/m/Y', Input::get('author_date_of_death'));

            
            if(Input::get('buyOrGift') == 'BUY'){
                //BUY INFO INPUT
                $buy_info_buy_date = DateTime::createFromFormat('d/m/Y', Input::get('buy_info_buy_date'));
                $buy_info_price_payed = Input::get('buy_info_price_payed');
                $buy_info_recommended_by = Input::get('buy_info_recommended_by');
                $buy_info_shop = Input::get('buy_info_shop');
                $buy_info_city = Input::get('buy_info_city');
                $buy_info_country = Input::get('buy_info_country');
                $book_info_retail_price = Input::get('buy_book_info_retail_price');
            }else{
                $gift_info_receipt_date = Input::get('gift_info_receipt_date');
                $gift_info_from = Input::get('gift_info_from');
                $gift_info_occasion = Input::get('gift_info_occasion');
                $book_info_retail_price = Input::get('gift_book_info_retail_price');
            }

            $publisher_country = $countryService->findOrSave($book_country);
            
            $book_author_model = $authorService->saveOrUpdate($book_author_name, '', $book_author_firstname, null, $book_author_date_of_birth, $book_author_date_of_death);
            $book_publisher = $publisherService->saveOrUpdate($book_publisher_name, $publisher_country);
            $publisherSerie = $publisherSerieService->findOrSave($book_publisher_serie, $book_publisher->id);
            $bookSerie = $bookSerieService->findOrSave($book_serie);
            $first_print_info = $this->createFirstPrintInfo();

            $book_from_author_id = $this->createBookFromAuthorLink($book_author_model->id);
            $book = new Book(array(
                'title' => $book_title,
                'subtitle' => $book_subtitle,
                'ISBN' => $book_isbn,
                'number_of_pages' => $book_number_of_pages,
                'print' => $book_print,
                'publication_date_id' => App::make('DateService')->createDate($book_publication_date_day, $book_publication_date_month, $book_publication_date_year)->id,
                'genre_id' => $book_genre_id,
                'type_of_cover' => $book_type_of_cover,
                'publisher_id' => $book_publisher->id,
                'publisher_country_id' => $publisher_country->id,
                'first_print_info_id' => $first_print_info->id,
                'coverImage' => $book_cover_image_file,
                'user_id' => Auth::user()->id,
                'publisher_serie_id' => $publisherSerie->id,
                'serie_id' => $bookSerie->id,
                'retail_price' => $book_info_retail_price,
                'book_from_author_id' => $book_from_author_id
            ));
        
            $book->save();
            $book->authors()->sync([$book_author_model->id], false);

            $personal_book_info = $this->createPersonalBookInfo($book);

            if(Input::get('buyOrGift') == 'BUY'){
                $buy_info_country = $countryService->findOrSave($buy_info_country);
                $buyInfoService->save($personal_book_info->id, $buy_info_buy_date, $buy_info_price_payed, $buy_info_recommended_by, $buy_info_shop, $buy_info_city, $buy_info_country->id);
            }else{
                $giftInfoService->save($personal_book_info->id, $gift_info_receipt_date, $gift_info_occasion, $gift_info_from);
            }
            return Redirect::to('/getBooks');
        }
    }

    private function createBookFromAuthorLink($author_id){
        $bookFromAuthorTitle = Input::get('bookFromAuthorTitle');

        App::make('OeuvreService')->linkNewOeuvreFromAuthor($author_id, Input::get('oeuvre'));

        $bookFromAuthorToBeLinked = BookFromAuthor::where('title', '=', $bookFromAuthorTitle)
            ->where('author_id', '=' , $author_id)
            ->first();

        if($bookFromAuthorToBeLinked != null){
            return $bookFromAuthorToBeLinked->id;
        }  
        return null;
    }

    private function createFirstPrintInfo(){
        $firstPrintInfoService = App::make('FirstPrintInfoService');

        $first_print_title = Input::get("first_print_title");
        $first_print_subtitle = Input::get("first_print_subtitle");
        $first_print_isbn = Input::get("first_print_isbn");
        $first_print_country = Input::get('first_print_country');
        $first_print_languageId = Input::get('first_print_languageId');
        $first_print_publication_date_day = Input::get('first_print_publication_date_day');
        $first_print_publication_date_month = Input::get('first_print_publication_date_month');
        $first_print_publication_date_year = Input::get('first_print_publication_date_year');
        $first_print_publisher_name = Input::get('first_print_publisher');

        $country = App::make('CountryService')->findOrSave($first_print_country);

        $first_print_publication_date = App::make('DateService')->createDate($first_print_publication_date_day, $first_print_publication_date_month, $first_print_publication_date_year);
        $first_print = $firstPrintInfoService->saveOrUpdate($first_print_title, 
                $first_print_subtitle, 
                $first_print_isbn, 
                $first_print_publication_date, 
                $first_print_publisher_name, 
                $country->id, 
                $first_print_languageId);
        return $first_print;
    }

    private function createPersonalBookInfo($book){
        $personalBookInfoService = App::make('PersonalBookInfoService');

        $personal_info_owned = Input::get('personal_info_owned');
        $personal_info_reason_not_owned = Input::get('personal_info_reason_not_owned');
        $personal_info_review = Input::get('personal_info_review');
        $personal_info_rating = Input::get('personal_info_rating');
        $personal_info_retail_price = Input::get('personal_info_retail_price');
        $personal_info_reading_dates = Input::get('personal_info_reading_dates');

        $string_reading_dates = explode(",", $personal_info_reading_dates);
        $reading_dates = array();
        foreach ($string_reading_dates as $string_reading_date) {
            array_push($reading_dates, DateTime::createFromFormat('d/m/Y', $string_reading_date));
        }

        $personal_book_info = $personalBookInfoService->save($book->id, 
            $personal_info_owned, 
            $personal_info_reason_not_owned, 
            $personal_info_review, 
            $personal_info_rating, 
            $personal_info_retail_price, 
            $reading_dates);
            
        return $personal_book_info;
    }

    private function checkCoverImage(){
        $logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

        $coverImage = null;
        $logger->info("Checking cover file...");
        if (Input::hasFile('book_cover_image'))
        {
            $logger->info("Input file for cover image found. Uploading cover image");
            $file = Input::file('book_cover_image');

            $userUsername = Auth::user()->username;
            $destinationPath = 'bookImages/' . $userUsername;

            $filename = $file->getClientOriginalName();
            $filename = str_random(8).'_'.$filename;
            $upload_success = Input::file('book_cover_image')->move($destinationPath, $filename);

            if( $upload_success == false) { 
                $logger->info("Uploading of coverImage failed!!");
                return Redirect::to('/createBook')->withErrors(array('book_cover_image' => 'Cover image could not be uploaded'))->withInput();
            }
            $coverImage = $destinationPath.'/'.$filename;
        }else{
            $coverImage = 'images/questionCover.png';
        }

        return $coverImage;
    }


}