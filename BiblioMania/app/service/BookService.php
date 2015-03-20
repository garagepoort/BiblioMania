<?php

class BookService
{

    public function getValueOfLibrary()
    {
        return DB::table('book')->where('user_id', '=', Auth::user()->id)->sum('retail_price');
    }

    public function getTotalAmountOfBooksInLibrary()
    {
        return DB::table('book')->where('user_id', '=', Auth::user()->id)->count();
    }

    public function getTotalAmountOfBooksOwned()
    {
        return Book::join('personal_book_info', 'book_id', '=', 'book.id')
            ->where('user_id', '=', Auth::user()->id)
            ->where('personal_book_info.owned', '=', 1)
            ->count();
    }

    public function getOrderByValues()
    {
        return array('title' => 'Titel', 'subtitle' => 'Ondertitel', 'author' => 'Auteur', 'rating' => 'Waardering');
    }

    public function getBooks()
    {
        return Book::where('user_id', '=', Auth::user()->id)->get();
    }

    public function getFilteredBooks($book_id, $book_title, $book_subtitle, $book_author_name, $book_author_firstname, $orderBy)
    {
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


        if ($book_id != null) {
            return Book::with($with)->where('user_id', '=', Auth::user()->id)
                ->where('id', '=', $book_id)
                ->paginate(60);
        }

        $books = Book::with($with)
            ->select(DB::raw('book.*'))
            ->join('book_author', 'book_author.book_id', '=', 'book.id')
            ->join('author', 'book_author.author_id', '=', 'author.id')
            ->join('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->join('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->join('date', 'date.id', '=', 'book.publication_date_id')
            ->where('book_author.preferred', '=', 1)
            ->where('user_id', '=', Auth::user()->id);

        if ($book_title != null) {
            $books = $books->where('book.title', 'LIKE', '%' . $book_title . '%');
        }
        if ($book_subtitle != null) {
            $books = $books->where('book.subtitle', 'LIKE', '%' . $book_subtitle . '%');
        }
        if ($book_author_name != null) {
            $books = $books->where('author.name', 'LIKE', '%' . $book_author_name . '%');
        }
        if ($book_author_firstname != null) {
            $books = $books->where('author.firstname', 'LIKE', '%' . $book_author_firstname . '%');
        }

        if ($orderBy == 'title') {
            $books = $books->orderBy('title');
        }
        if ($orderBy == 'subtitle') {
            $books = $books->orderBy('subtitle');
        }
        if ($orderBy == 'rating') {
            $books = $books->orderBy('personal_book_info.rating', 'DESC');
        }
        if ($orderBy == 'author') {
            $books = $books->orderBy('author.name');
        }

        $books = $books->orderBy('author.name');
        $books = $books->orderBy('date.year', 'ASC');
        $books = $books->orderBy('date.month', 'ASC');
        $books = $books->orderBy('date.day', 'ASC');
        return $books->paginate(60);
    }

    public function searchBooks($criteria){
        return Book::with(array(
            'authors' => function ($query) {
                $query->orderBy('name', 'DESC');
            },
            'publisher','genre','personal_book_info','first_print_info', 'publication_date', 'country', 'publisher_serie', 'serie'))

            ->where('user_id', '=', Auth::user()->id)
            ->where(function ($query) use ($criteria) {
                $query->where('title', 'LIKE', '%' . $criteria . '%')
                    ->orWhere('subtitle', 'LIKE', '%' . $criteria . '%');
            })

            ->orderBy('title')
            ->paginate(60);
    }
}