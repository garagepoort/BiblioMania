<?php

class BookController extends BaseController {

	private $bookFolder = "book/";

	public function getBooks()
	{
        $books = Book::where("user_id", "=", Auth::user()->id)->paginate(25);
		return View::make('books')->with(array(
            'title' => 'Boeken',
            'books' => $books,
            'books_json' => $books->toJson()
            ));
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
            'authors_json' => json_encode(Author::where("user_id", "=", Auth::user()->id)->get())
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
            $personal_info_review = Input::get('personal_info_review');
            $personal_info_rating = Input::get('personal_info_rating');
            $personal_info_retail_price = Input::get('personal_info_retail_price');
            $personal_info_reading_dates = Input::get('personal_info_reading_dates');


            //AUTHOR INPUT
            $book_author_name = Input::get('author_name');
            $book_author_firstname = Input::get('author_firstname');
            $book_author_date_of_birth = DateTime::createFromFormat('d/m/Y', Input::get('author_date_of_birth'));
            $book_author_date_of_death = DateTime::createFromFormat('d/m/Y', Input::get('author_date_of_death'));
            

            $authorService = App::make('AuthorService');
            $publisherService = App::make('PublisherService');
            $firstPrintInfoService = App::make('FirstPrintInfoService');
            $personalBookInfoService = App::make('PersonalBookInfoService');
            $publisherSerieService = App::make('PublisherSerieService');
            $bookSerieService = App::make('BookSerieService');

            $book_author_model = $authorService->saveOrUpdate($book_author_name, $book_author_firstname, $book_author_date_of_birth, $book_author_date_of_death);
            $book_publisher = $publisherService->saveOrUpdate($book_publisher_name, Country::find($book_countryId));
            $first_print_info = $firstPrintInfoService->saveOrUpdate($first_print_title, $first_print_subtitle, $first_print_isbn, $first_print_publication_date, $first_print_publisher_name, $first_print_countryId, $first_print_languageId);
            $publisherSerie = $publisherSerieService->findOrSave($book_publisher_serie);
            $bookSerie = $bookSerieService->findOrSave($book_serie);

			$book = new Book(array(
                'title' => $book_title,
                'subtitle' => $book_subtitle,
                'ISBN' => $book_isbn,
                'number_of_pages' => $book_number_of_pages,
                'print' => $book_print,
                'publication_date' => $book_publication_date,
                'genre_id' => $book_genre_id,
                'type_of_cover' => $book_type_of_cover,
                'author_id' => $book_author_model->id,
                'publisher_id' => $book_publisher->id,
                'first_print_info_id' => $first_print_info->id,
                'coverImage' => $book_cover_image_file,
                'user_id' => Auth::user()->id,
                'publisher_serie_id' => $publisherSerie->id,
                'serie_id' => $bookSerie->id
            ));
            $book->save();

            $string_reading_dates = explode(",", $personal_info_reading_dates);
            $reading_dates = array();
            foreach ($string_reading_dates as $string_reading_date) {
                array_push($reading_dates, DateTime::createFromFormat('d/m/Y', $string_reading_date));
            }
            $personalBookInfoService->save($book->id, $personal_info_owned, $personal_info_review, $personal_info_rating, $personal_info_retail_price, $reading_dates);
            
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

            $userEmail = Auth::user()->email;
            $destinationPath = $userEmail;

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