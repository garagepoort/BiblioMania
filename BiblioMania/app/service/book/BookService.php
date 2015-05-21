<?php

class BookService
{

    /** @var  ImageService */
    private $imageService;
    /** @var  BookRepository */
    private $bookRepository;

    function __construct()
    {
        $this->imageService = App::make('ImageService');
        $this->bookRepository = App::make('BookRepository');
    }

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

    public function getBooksWithPersonalBookInfo(){
        return Book::with("personal_book_info")->where('user_id', '=', Auth::user()->id)->get();
    }

    public function getFullBook($book_id){
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

        return Book::with($with)->where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $book_id)
            ->get();
    }

    public function getFilteredBooks($book_id, $book_title, $book_subtitle, $book_author_name, $book_author_firstname, $orderBy)
    {
        if ($book_id != null) {
            return Book::where('user_id', '=', Auth::user()->id)
                ->where('id', '=', $book_id)
                ->paginate(60);
        }

        $books = Book::select(DB::raw('book.*'))
            ->leftJoin('book_author', 'book_author.book_id', '=', 'book.id')
            ->leftJoin('author', 'book_author.author_id', '=', 'author.id')
            ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date', 'date.id', '=', 'book.publication_date_id')
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

    public function searchBooks($criteria)
    {
        return Book::with(array(
            'authors' => function ($query) {
                $query->orderBy('name', 'DESC');
            },
            'publisher', 'genre', 'personal_book_info', 'first_print_info', 'publication_date', 'country', 'publisher_serie', 'serie'))
            ->where('user_id', '=', Auth::user()->id)
            ->where(function ($query) use ($criteria) {
                $query->where('title', 'LIKE', '%' . $criteria . '%')
                    ->orWhere('subtitle', 'LIKE', '%' . $criteria . '%');
            })
            ->orderBy('title')
            ->paginate(60);
    }

    /**
     * @param BookCreationParameters $bookCreationParameters
     * @return Book
     */
    public function createBook(BookCreationParameters $bookCreationParameters, Publisher $publisher, Country $country, FirstPrintInfo $firstPrintInfo)
    {
        $book = new Book();
        if ($bookCreationParameters->getBookInfoParameters()->getBookId() != null && $bookCreationParameters->getBookInfoParameters()->getBookId() != '') {
            $book = Book::find($bookCreationParameters->getBookInfoParameters()->getBookId());
        }
        $book->title = $bookCreationParameters->getBookInfoParameters()->getTitle();
        $book->subtitle = $bookCreationParameters->getBookInfoParameters()->getSubtitle();
        $book->ISBN = $bookCreationParameters->getBookInfoParameters()->getIsbn();
        $book->number_of_pages = $bookCreationParameters->getExtraBookInfoParameters()->getPages();
        $book->print = $bookCreationParameters->getExtraBookInfoParameters()->getPrint();
        $book->genre_id = $bookCreationParameters->getBookInfoParameters()->getGenre();
        $book->type_of_cover = $bookCreationParameters->getCoverInfoParameters()->getCoverType();
        $book->user_id = Auth::user()->id;
        $book->retail_price = $bookCreationParameters->getBookInfoParameters()->getRetailPrice();
        $book->publisher_id = $publisher->id;
        $book->publisher_country_id = $country->id;
        $book->first_print_info_id = $firstPrintInfo->id;
        if ($bookCreationParameters->getBookInfoParameters()->getLanguage() != null) {
            $book->language()->associate($bookCreationParameters->getBookInfoParameters()->getLanguage());
        }
        if ($bookCreationParameters->getBookInfoParameters()->getPublicationDate() != null) {
            $book->publication_date()->associate($bookCreationParameters->getBookInfoParameters()->getPublicationDate());
        }

        $imagePath = 'images/questionCover.png';
        if ($bookCreationParameters->getCoverInfoParameters()->getImage() != null) {
            if ($bookCreationParameters->getCoverInfoParameters()->getShouldCreateImage()) {
                $imagePath = $this->imageService->saveImage($bookCreationParameters->getCoverInfoParameters()->getImage(), $bookCreationParameters->getBookInfoParameters()->getTitle());
            } else {
                $imagePath = $bookCreationParameters->getCoverInfoParameters()->getImage();
            }
        }
        $book->coverImage = $imagePath;

        $this->bookRepository->save($book);
        return $book;
    }
}