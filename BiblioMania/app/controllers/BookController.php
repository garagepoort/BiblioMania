<?php

class BookController extends BaseController {

	private $bookFolder = "book/";

	public function getBooks()
	{
		return View::make('books')->with(array('title' => 'Boeken'));
	}

	public function goToCreateBook()
	{
		$covers = array("Hard cover", "Soft cover", "Other");
		return View::make($this->bookFolder . 'createBook')->with(array(
			'title' => 'Boek toevoegen',
			'countries' => App::make('CountryService')->getCountries(),
			'languages' => App::make('LanguageService')->getLanguages(),
			'covers' => $covers
			));
	}

	public function createBook(){
		$rules = array(
            'book_title' => 'required',
            'book_author' => 'required',
            'book_isbn' => 'required|numeric|digits:13',
            'book_publication_date' => 'required|date_format:"d/m/Y"',
            'book_publisher' => 'required',
            'book_genre' => 'required'
        );
        $validator = Validator::make(Input::get(), $rules);
        
        if($validator->fails()){
            return Redirect::to('/createBook')->withErrors($validator)->withInput();
        }else{
        	$title = Input::get("book_title");
            $subtitle = Input::get("book_subtitle");
            $author = Input::get("book_author");
            $isbn = Input::get("book_isbn");
            $number_of_pages = Input::get("book_number_of_pages");
            $print = Input::get("book_print");
            $countryId = Input::get('book_countryId');
            $language = Input::get('book_languageId');
            $book_publication_date = Input::get('book_publication_date');
            $genre = Input::get('book_genre');
            $type_of_cover = Input::get('book_type_of_cover');
            $publisher = Input::get('book_publisher');

            $author_arr = array_map('trim', explode(',', $author));
            $author_name = $author_arr[0];
            $author_firstname = $author_arr[1];
            // $date = DateTime::createFromFormat('d/m/Y', $datum);

            $author_model = Author::where('name', '=', $author_name)
	            ->where('firstname', '=', $author_firstname)
	            ->first();

            $publisher = Publisher::where('name', '=', $publisher)
            	->first();

            if (is_null($author_model)) {
            	$author_model = new Author(array(
	            	'firstname' => $author_firstname,
	            	'name' => $author_name
            	));
            	$author_model->save();
            }
            if (is_null($publisher)) {
            	$publisher = new Publisher(array(
	            	'name' => $publisher
	            ));
	            $country = Country::find($countryId);
	            $publisher->countries()->save();
            	$publisher->save();
            }

			$book = new Book(array(
                'title' => $title,
                'subtitle' => $subtitle,
                'author' => $author,
                'isbn' => $isbn,
                'number_of_pages' => $number_of_pages,
                'print' => $print,
                'book_publication_date' => $book_publication_date,
                'genre_id' => 1,
                'type_of_cover' => $type_of_cover,
                'author_id' => $author_model->id,
                'publisher_id' => $publisher->id
            ));
            $book->save();
        }
	}


}