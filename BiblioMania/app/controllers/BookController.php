<?php

class BookController extends BaseController {

	private $bookFolder = "book/";

    private function cmp($a, $b)
    {
        return strcmp($a->name, $b->name);
    }

	public function getBooks($order = 'title')
	{

        $books = Book::where('user_id' , '=', Auth::user()->id)->orderBy('title')->paginate(60);
        // usort($books->getCollection(), array($this, "cmp"));

		return View::make('books')->with(array(
            'title' => 'Boeken',
            'books' => $books,
            'books_json' => $books->toJson(),
            'total_value_library' => App::make('BookService')->getValueOfLibrary(),
            'total_amount_of_books' => App::make('BookService')->getTotalAmountOfBooksInLibrary()
            ));
	}

    public function getBooksFromSearch(){
        $criteria = Input::get('criteria');
        $books = Book::where('user_id' , '=', Auth::user()->id)
                ->where(function ($query) use ($criteria){
                     $query->where('title', 'LIKE', '%'.$criteria.'%')
                    ->orWhere('subtitle', 'LIKE', '%'.$criteria.'%');
                })
                ->orderBy('title')
                ->paginate(60);

        return View::make('books')->with(array(
            'title' => 'Boeken',
            'books' => $books,
            'books_json' => $books->toJson()
            ));
    }

    public function getJsonBook($book_id){
        return Book::find($book_id);
    }

	public function goToCreateBook()
	{
		$covers = array("Hard cover", "Soft cover", "Other");
        $genres = Genre::where('parent_id' , '=', null)->get();

		return View::make($this->bookFolder . 'createBook')->with(array(
			'title' => 'Boek toevoegen',
			'countries' => App::make('CountryService')->getCountries(),
			'languages' => App::make('LanguageService')->getLanguages(),
            'covers' => $covers,
			'genres' => $genres,
            'authors_json' => json_encode(Author::all())
			));
	}

	public function createBook(){

		$rules = array(
            'book_title' => 'required',
            'book_author' => 'required',
            'book_isbn' => 'required|numeric|digits:13',
            'book_number_of_pages' => 'numeric',
            'book_print' => 'numeric',
            'book_publication_date' => 'required|date_format:"d/m/Y"',
            'book_publisher' => 'required',
            'book_serie' => 'required',
            'book_publisher_serie' => 'required',
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
            $firstPrintInfoService = App::make('FirstPrintInfoService');
            $personalBookInfoService = App::make('PersonalBookInfoService');
            $publisherSerieService = App::make('PublisherSerieService');
            $bookSerieService = App::make('BookSerieService');
            $buyInfoService = App::make('BuyInfoService');
            $giftInfoService = App::make('GiftInfoService');

            $book_cover_image_file = $this->checkCoverImage();

            //BOOK INPUT
            $book_title = Input::get("book_title");
            $book_subtitle = Input::get("book_subtitle");
            $book_isbn = Input::get("book_isbn");
            $book_number_of_pages = Input::get("book_number_of_pages");
            $book_print = Input::get("book_print");
            $book_countryId = Input::get('book_countryId');
            $book_language = Input::get('book_languageId');
            $book_publication_date = DateTime::createFromFormat('d/m/Y', Input::get('book_publication_date'));
            $book_genre_id = Input::get('book_genre');
            $book_type_of_cover = Input::get('book_type_of_cover');
            $book_publisher_name = Input::get('book_publisher');
            $book_publisher_serie = Input::get('book_publisher_serie');
            $book_serie = Input::get('book_serie');
            

            //FIRST PRINT INPUT
            $first_print_title = Input::get("first_print_title");
            $first_print_subtitle = Input::get("first_print_subtitle");
            $first_print_isbn = Input::get("first_print_isbn");
            $first_print_countryId = Input::get('first_print_countryId');
            $first_print_languageId = Input::get('first_print_languageId');
            $first_print_publication_date = DateTime::createFromFormat('d/m/Y', Input::get('first_print_publication_date'));
            $first_print_publisher_name = Input::get('first_print_publisher');

            

            //PERSONAL INFO INPUT
            $personal_info_owned = Input::get('personal_info_owned');
            $personal_info_reason_not_owned = Input::get('personal_info_reason_not_owned');
            $personal_info_review = Input::get('personal_info_review');
            $personal_info_rating = Input::get('personal_info_rating');
            $personal_info_retail_price = Input::get('personal_info_retail_price');
            $personal_info_reading_dates = Input::get('personal_info_reading_dates');


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
                $buy_info_countryId = Input::get('buy_info_countryId');
                $book_info_retail_price = Input::get('buy_book_info_retail_price');
            }else{
                $gift_info_receipt_date = Input::get('gift_info_receipt_date');
                $gift_info_from = Input::get('gift_info_from');
                $gift_info_occasion = Input::get('gift_info_occasion');
                $book_info_retail_price = Input::get('gift_book_info_retail_price');
            }

            
            $book_author_model = $authorService->saveOrUpdate($book_author_name, null, $book_author_firstname, $book_author_date_of_birth, $book_author_date_of_death);
            $book_publisher = $publisherService->saveOrUpdate($book_publisher_name, Country::find($book_countryId));
            $publisherSerie = $publisherSerieService->findOrSave($book_publisher_serie, $book_publisher->id);
            $bookSerie = $bookSerieService->findOrSave($book_serie);
            $first_print_info = $firstPrintInfoService->saveOrUpdate($first_print_title, $first_print_subtitle, $first_print_isbn, $first_print_publication_date, $first_print_publisher_name, $first_print_countryId, $first_print_languageId);
            

            $book = new Book(array(
                'title' => $book_title,
                'subtitle' => $book_subtitle,
                'ISBN' => $book_isbn,
                'number_of_pages' => $book_number_of_pages,
                'print' => $book_print,
                'publication_date' => $book_publication_date,
                'genre_id' => $book_genre_id,
                'type_of_cover' => $book_type_of_cover,
                'publisher_id' => $book_publisher->id,
                'first_print_info_id' => $first_print_info->id,
                'coverImage' => $book_cover_image_file,
                'user_id' => Auth::user()->id,
                'publisher_serie_id' => $publisherSerie->id,
                'serie_id' => $bookSerie->id,
                'retail_price' => $book_info_retail_price
            ));
            $book->save();
            $book->authors()->sync([$book_author_model->id], false);

            $string_reading_dates = explode(",", $personal_info_reading_dates);
            $reading_dates = array();
            foreach ($string_reading_dates as $string_reading_date) {
                array_push($reading_dates, DateTime::createFromFormat('d/m/Y', $string_reading_date));
            }
            $personal_book_info = $personalBookInfoService->save($book->id, $personal_info_owned, $personal_info_reason_not_owned, $personal_info_review, $personal_info_rating, $personal_info_retail_price, $reading_dates);
            
            if(Input::get('buyOrGift') == 'BUY'){
                $buyInfoService->save($personal_book_info->id, $buy_info_buy_date, $buy_info_price_payed, $buy_info_recommended_by, $buy_info_shop, $buy_info_city, $buy_info_countryId);
            }else{
                $giftInfoService->save($personal_book_info->id, $gift_info_receipt_date, $gift_info_occasion, $gift_info_from);
            }
            return Redirect::to('/getBooks');
        }
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