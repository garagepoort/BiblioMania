<?php

class BookService {

	public function getValueOfLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->sum('retail_price');
	}

	public function getTotalAmountOfBooksInLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->count();
	}

	public function getTotalAmountOfBooksOwned(){
		return  Book::join('personal_book_info', 'book_id', '=', 'book.id')
					->where('user_id', '=', Auth::user()->id)
					->where('personal_book_info.owned', '=', 1)
					->count();
	}

    public function getOrderByValues(){
        return array('title'=>'Titel', 'subtitle'=>'Ondertitel', 'author'=>'Auteur', 'rating'=>'Waardering');
    }

	public function getBooks(){
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
		return Books::with($with)->where('user_id', '=', Auth::user()->id)->get();
	}

	public function getFilteredBooks($book_id, $book_title, $book_subtitle, $book_author_name, $book_author_firstname, $orderBy){
        $with = array(
                'authors',
                'publisher', 
                'genre', 
                'personal_book_info', 
                'first_print_info',
                'publication_date', 
                'country',
                'publisher_serie', 
                'serie');


        if($book_id != null){
            return Book::with($with)->where('user_id' , '=', Auth::user()->id)
                    ->where('id', '=', $book_id)
                    ->paginate(60);
        }

        $books = Book::with($with)->where('user_id' , '=', Auth::user()->id);

        if($book_title != null){
            $books = $books->where('title', 'LIKE', '%'.$book_title.'%');
        }
        if($book_subtitle !=null){
            $books = $books->where('subtitle', 'LIKE', '%'.$book_subtitle.'%');
        }
        if($book_author_name != null){
            $books = $books->whereHas('authors', function($q) use ($book_author_name){
                $q->where('name', 'LIKE', '%'.$book_author_name.'%');
            });
        }
        if($book_author_firstname != null) {
            $books = $books->whereHas('authors', function ($q) use ($book_author_firstname) {
                $q->where('firstname', 'LIKE', '%' . $book_author_firstname . '%');
            });
        }

        $books = $books->get();

        $books = $books->sortByDesc(function($book) use ($orderBy)
		{
			if($orderBy == 'title'){
		    	return $book->title;
			}
			if($orderBy == 'subtitle'){
		    	return $book->subtitle;
			}
            if($orderBy == 'author'){
		    	return $book->authors[0]->name;
			}
            if($orderBy == 'rating'){
		    	return $book->personal_book_info->rating;
			}
		    return $book->authors[0]->name;
		});

        $perPage = 60;
        $currentPage = Input::get('page') - 1;
        $pagedData = array_slice($books->toArray(), $currentPage * $perPage, $perPage);
        $books = Paginator::make($pagedData, count($books), $perPage);
		return $books;
	}

    private function sortBooks($orderBy = 'author', $books){
        switch($orderBy){
            case 'author':
                return $books->sortBy(function($book) use ($orderBy){ return $book->authors[0]->name; });
                break;
            case 'title':
                return $books->sortBy(function($book) use ($orderBy){ return $book->title; });
                break;
            case 'subtitle':
                return $books->sortBy(function($book) use ($orderBy){ return $book->subtitle; });
                break;
            case 'rating':
                return $books->sortByDesc(function($book) use ($orderBy){ return $book->personal_book_info->rating; });
                break;
        }
    }
}