<?php

class BookService
{

    /** @var  BookRepository */
    private $bookRepository;
    /** @var  PublisherSerieService */
    private $publisherSerieService;
    /** @var  BookSerieService */
    private $bookSerieService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;
    /** @var  ImageService */
    private $imageService;


    function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookSerieService = App::make('BookSerieService');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->imageService = App::make('ImageService');
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

    public function getBooksWithPersonalBookInfo()
    {
        return Book::with("personal_book_info")->where('user_id', '=', Auth::user()->id)->get();
    }

    public function getFullBook($book_id)
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

        return Book::with($with)->where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $book_id)
            ->get();
    }

    public function getFilteredBooks($book_id, BookFilterValues $bookFilterValues, $orderBy)
    {
        if ($book_id != null) {
            return Book::where('user_id', '=', Auth::user()->id)
                ->where('id', '=', $book_id)
                ->paginate(60);
        }

        $books = Book::select(DB::raw('book.*'))
            ->leftJoin('serie', 'book.serie_id', '=', 'serie.id')
            ->leftJoin('publisher_serie', 'book.publisher_serie_id', '=', 'publisher_serie.id')
            ->leftJoin('book_author', 'book_author.book_id', '=', 'book.id')
            ->leftJoin('author', 'book_author.author_id', '=', 'author.id')
            ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date', 'date.id', '=', 'book.publication_date_id')
            ->where('book_author.preferred', '=', 1)
            ->where('user_id', '=', Auth::user()->id);

        //FILTERS
        if ($bookFilterValues->getRead() == BookFilterValues::YES) {
            $books = $books->where("personal_book_info.read", '=', true);
        } else if ($bookFilterValues->getRead() == BookFilterValues::NO) {
            $books = $books->where("personal_book_info.read", '=', false);
        }

        if ($bookFilterValues->getOwns() == BookFilterValues::YES) {
            $books = $books->where("personal_book_info.owned", '=', true);
        } else if ($bookFilterValues->getOwns() == BookFilterValues::NO) {
            $books = $books->where("personal_book_info.owned", '=', false);
        }


        $operatorString = "=";
        $queryString = $bookFilterValues->getQuery();
        if (!StringUtils::isEmpty($queryString)) {
            if ($bookFilterValues->getOperator() == FilterOperator::BEGINS_WITH || $bookFilterValues->getOperator() == FilterOperator::CONTAINS || $bookFilterValues->getOperator() == FilterOperator::ENDS_WITH) {
                $operatorString = "LIKE";
                if ($bookFilterValues->getOperator() == FilterOperator::BEGINS_WITH) {
                    $queryString = $queryString . '%';
                }
                if ($bookFilterValues->getOperator() == FilterOperator::ENDS_WITH) {
                    $queryString = '%' . $queryString;
                }
                if ($bookFilterValues->getOperator() == FilterOperator::CONTAINS) {
                    $queryString = '%' . $queryString . '%';
                }
            }

            //SEARCH
            if ($bookFilterValues->getType() != BookFilterType::ALL) {
                $books = $books->where($bookFilterValues->getType(), $operatorString, $queryString);
            } else {
                $books = $books->where(function ($query) use ($operatorString, $queryString) {
                    $query->Where(BookFilterType::AUTHOR_NAME, $operatorString, $queryString)
                        ->orWhere(BookFilterType::AUTHOR_FIRSTNAME, $operatorString, $queryString)
                        ->orWhere(BookFilterType::PUBLISHER_SERIE, $operatorString, $queryString)
                        ->orWhere(BookFilterType::BOOK_SERIE, $operatorString, $queryString)
                        ->orWhere(BookFilterType::BOOK_TITLE, $operatorString, $queryString);
                });
            }
        }

        //ORDER BY
        if ($orderBy == 'title') {
            $books = $books->orderBy('title');
        }
        if ($orderBy == 'subtitle') {
            $books = $books->orderBy('subtitle');
        }
        if ($orderBy == 'rating') {
            $books = $books->orderBy('personal_book_info.rating', 'DESC');
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
    public function createBook(BookCreationParameters $bookCreationParameters, Publisher $publisher, Country $country, FirstPrintInfo $firstPrintInfo, Author $author)
    {

        $book = new Book();
        if (!StringUtils::isEmpty($bookCreationParameters->getBookInfoParameters()->getBookId())) {
            $book = $this->bookRepository->find($bookCreationParameters->getBookInfoParameters()->getBookId());
        }
        $book->title = $bookCreationParameters->getBookInfoParameters()->getTitle();
        $book->subtitle = $bookCreationParameters->getBookInfoParameters()->getSubtitle();
        $book->ISBN = $bookCreationParameters->getBookInfoParameters()->getIsbn();
        $book->number_of_pages = $bookCreationParameters->getExtraBookInfoParameters()->getPages();
        $book->print = $bookCreationParameters->getExtraBookInfoParameters()->getPrint();
        $book->genre_id = $bookCreationParameters->getBookInfoParameters()->getGenre();
        $book->translator = $bookCreationParameters->getExtraBookInfoParameters()->getTranslator();
        $book->summary = $bookCreationParameters->getExtraBookInfoParameters()->getSummary();
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
        if(!StringUtils::isEmpty($bookCreationParameters->getExtraBookInfoParameters()->getPublisherSerie())){
            $publisherSerie = $this->publisherSerieService->findOrSave($bookCreationParameters->getExtraBookInfoParameters()->getPublisherSerie(), $publisher->id);
            $book->publisher_serie()->associate($publisherSerie);
        }
        if(!StringUtils::isEmpty($bookCreationParameters->getExtraBookInfoParameters()->getBookSerie())){
            $bookSerie = $this->bookSerieService->findOrSave($bookCreationParameters->getExtraBookInfoParameters()->getBookSerie());
            $book->serie()->associate($bookSerie);
        }
        if(!StringUtils::isEmpty($bookCreationParameters->getAuthorInfoParameters()->getLinkedBook())){
            $bookFromAuthor = $this->bookFromAuthorService->find($bookCreationParameters->getAuthorInfoParameters()->getLinkedBook(), $author->id);
            $book->book_from_author()->associate($bookFromAuthor);
        }

        $this->saveImage($bookCreationParameters->getCoverInfoParameters(), $book);
        $this->bookRepository->save($book);
        return $book;
    }


    public function saveImage(CoverInfoParameters $coverInfoParameters, $book)
    {
        if($coverInfoParameters->getImage() != null){
            if($book->image != 'images/questionCover.png'){
                $this->imageService->removeImage($book->coverImage);
            }
            if($coverInfoParameters->getImageSaveType() == ImageSaveType::UPLOAD){
                $book->coverImage = $this->imageService->saveUploadImage($coverInfoParameters->getImage(),
                    $book->title);
            }
            else if($coverInfoParameters->getImageSaveType() == ImageSaveType::URL){
                $book->coverImage = $this->imageService->saveImageFromUrl($coverInfoParameters->getImage(), $book->title);
            }
            else if($coverInfoParameters->getImageSaveType() == ImageSaveType::PATH){
                $book->coverImage = $coverInfoParameters->getImage();
            }
        }else if(StringUtils::isEmpty($book->coverImage)){
            $book->coverImage = 'images/questionCover.png';
        }
    }
}