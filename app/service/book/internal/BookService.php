<?php

use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookService
{
    const PAGES = 1000;
    const COMPLETE = "COMPLETE";

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
    /** @var  TagService */
    private $tagService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  AuthorService */
    private $authorService;
    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var BookFilterManager $bookFilterManager */
    private $bookFilterManager;
    /** @var GenreService */
    private $genreService;

    function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookSerieService = App::make('BookSerieService');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
        $this->imageService = App::make('ImageService');
        $this->tagService = App::make('TagService');
        $this->languageService = App::make('LanguageService');
        $this->authorService = App::make('AuthorService');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->bookFilterManager = App::make('BookFilterManager');
        $this->genreService = App::make('GenreService');
    }

    public function find($id, $with = array())
    {
        return $this->bookRepository->find($id, $with);
    }

    public function allBooks(){
        return $this->bookRepository->allWith(array('personal_book_info', 'authors'));
    }

    public function create(CreateBookRequest $createBookRequest){
        return DB::transaction(function() use ($createBookRequest){
            $book = new Book();
            $genre = $this->genreService->getGenreByName($createBookRequest->getGenre());
            $author = $this->authorService->find($createBookRequest->getPreferredAuthorId());

            Ensure::objectNotNull("Book", $book);
            Ensure::objectNotNull("Author", $author);
            Ensure::objectNotNull("Genre", $genre);
            Ensure::objectNotNull("PublicationDate", $createBookRequest->getPublicationDate());
            Ensure::stringNotBlank("Language", $createBookRequest->getLanguage());
            Ensure::stringNotBlank("Title", $createBookRequest->getTitle());
            Ensure::stringNotBlank("Isbn", $createBookRequest->getIsbn());
            Ensure::stringNotBlank("Publisher", $createBookRequest->getPublisher());
            Ensure::stringNotBlank("Country", $createBookRequest->getCountry());

            $bookPublisher = $this->publisherService->findOrCreate($createBookRequest->getPublisher());
            $country = $this->countryService->findOrCreate($createBookRequest->getCountry());
            $book->language()->associate($this->languageService->findOrSave($createBookRequest->getLanguage()));

            $tagsAsStrings = $this->mapTags($createBookRequest);
            $tags = $this->tagService->createTags($tagsAsStrings);

            $date = $this->createPublicationDate($createBookRequest);
            $book->publication_date()->associate($date);

            $book->title = $createBookRequest->getTitle();
            $book->subtitle = $createBookRequest->getSubtitle();
            $book->ISBN = $createBookRequest->getIsbn();
            $book->genre_id = $genre->id;
            $book->publisher_id = $bookPublisher->id;
            $book->publisher_country_id = $country->id;

            if(!StringUtils::isEmpty($createBookRequest->getImageUrl())){
                $book->coverImage = $this->imageService->saveBookImageFromUrl($createBookRequest->getImageUrl(), $book);
            }

            $this->bookRepository->save($book);
            $book->tags()->sync($tags);
            $this->authorService->syncAuthors($author, [], $book);

            $personBookInfo = new PersonalBookInfo();
            $personBookInfo->book_id = $book->id;
            $personBookInfo->save();

            return $book;
        });
    }

    public function getBooksByAuthor($authorId){
        return $this->bookRepository->booksFromAuthor($authorId);
    }

    public function linkAuthorToBook($bookId, LinkAuthorToBookRequest $authorToBookRequest){
        /** @var Book $book */
        $book = $this->find($bookId);
        Ensure::objectNotNull('book', $book);
        $author = $this->authorService->find($authorToBookRequest->getAuthorId());
        Ensure::objectNotNull('author', $author);

        $book->authors()->attach($authorToBookRequest->getAuthorId(), ['preferred'=>false]);
    }

    public function unlinkAuthorFromBook($bookId, UnlinkAuthorToBookRequest $authorToBookRequest){
        /** @var Book $book */
        $book = $this->find($bookId);
        Ensure::objectNotNull('book', $book);
        $author = $book->authors->find($authorToBookRequest->getAuthorId());
        Ensure::objectNotNull('author', $author);

        if($author->pivot->preferred){
            throw new ServiceException('Preferred author cannot be unlinked from book.');
        }

        $book->authors()->detach($authorToBookRequest->getAuthorId());
    }

    public function getValueOfLibrary()
    {
        $this->bookRepository->getValueOfLibrary();
    }

    public function getTotalAmountOfBooksInLibrary()
    {
        return $this->bookRepository->getTotalAmountOfBooksInLibrary();
    }

    public function getTotalAmountOfBooksOwned()
    {
        return $this->bookRepository->getTotalAmountOfBooksOwned();
    }

    public function getCompletedBooksForList()
    {
        return $this->bookRepository->allWith(array('publisher', 'authors'));
    }

    public function getCompletedBooksWithPersonalBookInfo()
    {
        return $this->bookRepository->allWith(array('personal_book_info'));
    }

    public function getFullBook($book_id)
    {
        $with = array(
            'authors',
            'tags',
            'publisher',
            'genre',
            'personal_book_info',
            'first_print_info',
            'publication_date',
            'country',
            'publisher_serie',
            'serie');

        return $this->bookRepository->find($book_id, $with);
    }

    public function getAllCompletedFullBooks()
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

        return $this->bookRepository->allWith($with);
    }

    public function filterBooks($filters){
        $books = Book::select(DB::raw('book.*'))
            ->leftJoin('serie', 'book.serie_id', '=', 'serie.id')
            ->leftJoin('publisher_serie', 'book.publisher_serie_id', '=', 'publisher_serie.id')
            ->leftJoin('book_author', 'book_author.book_id', '=', 'book.id')
            ->leftJoin('author', 'book_author.author_id', '=', 'author.id')
            ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date', 'date.id', '=', 'first_print_info.publication_date_id')
            ->leftJoin("personal_book_info_reading_date", "personal_book_info.id", "=","personal_book_info_reading_date.personal_book_info_id")
            ->leftJoin("reading_date", "personal_book_info_reading_date.reading_date_id", "=", "reading_date.id")
            ->with('personal_book_info')
            ->where('book_author.preferred', '=', 1)
            ->where('personal_book_info.user_id', '=', Auth::user()->id);

        foreach($filters as $filter){
            $books = $this->bookFilterManager->handle($filter['id'], $books, $filter['value'], $filter['operator']);
        }

        $books = $books->orderBy('author.name');
        $books = $books->orderBy('author.firstname');
        $books = $books->orderBy('date.year', 'ASC');
        $books = $books->orderBy('date.month', 'ASC');
        $books = $books->orderBy('date.day', 'ASC');

        list($totalValue, $totalAmountOfBooks, $totalAmountOfBooksOwned) = $this->getCollectionInformation(clone $books);

        return new FilteredBooksResult($totalAmountOfBooks, $totalAmountOfBooksOwned, $totalValue, $books->paginate(self::PAGES));
    }


    public function searchBooks($book_id, BookSearchValues $bookFilterValues, $orderBy)
    {
        if ($book_id != null) {
            $books = Book::select(DB::raw('book.*'))
                ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
                ->with('personal_book_info')
                ->where('user_id', '=', Auth::user()->id)
                ->where('book.id', '=', $book_id);

            list($totalValue, $totalAmountOfBooks, $totalAmountOfBooksOwned) = $this->getCollectionInformation(clone $books);

            return new FilteredBooksResult($totalAmountOfBooks, $totalAmountOfBooksOwned, $totalValue, $books->paginate(self::PAGES));
        }

        $books = Book::select(DB::raw('book.*'))
            ->leftJoin('serie', 'book.serie_id', '=', 'serie.id')
            ->leftJoin('publisher_serie', 'book.publisher_serie_id', '=', 'publisher_serie.id')
            ->leftJoin('book_author', 'book_author.book_id', '=', 'book.id')
            ->leftJoin('genre', 'genre.id', '=', 'book.genre_id')
            ->leftJoin('genre as genre_parent', 'genre.parent_id', '=', 'genre_parent.id')
            ->leftJoin('author', 'book_author.author_id', '=', 'author.id')
            ->leftJoin('personal_book_info', 'personal_book_info.book_id', '=', 'book.id')
            ->leftJoin('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
            ->leftJoin('date', 'date.id', '=', 'first_print_info.publication_date_id')
            ->with('personal_book_info')
            ->where('book_author.preferred', '=', 1)
            ->where('user_id', '=', Auth::user()->id);

        //FILTERS
        if ($bookFilterValues->getRead() == BookSearchValues::YES) {
            $books = $books->where("personal_book_info.read", '=', true);
        } else if ($bookFilterValues->getRead() == BookSearchValues::NO) {
            $books = $books->where("personal_book_info.read", '=', false);
        }

        if ($bookFilterValues->getOwns() == BookSearchValues::YES) {
            $books = $books->where("personal_book_info.owned", '=', true);
        } else if ($bookFilterValues->getOwns() == BookSearchValues::NO) {
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
            if ($bookFilterValues->getType() != BookSearchType::ALL) {
                $books = $books->where($bookFilterValues->getType(), $operatorString, $queryString);
            } else {
                $books = $books->where(function ($query) use ($operatorString, $queryString) {
                    $query->Where(BookSearchType::AUTHOR_NAME, $operatorString, $queryString)
                        ->orWhere(BookSearchType::AUTHOR_FIRSTNAME, $operatorString, $queryString)
                        ->orWhere(BookSearchType::PUBLISHER_SERIE, $operatorString, $queryString)
                        ->orWhere(BookSearchType::BOOK_SERIE, $operatorString, $queryString)
                        ->orWhere(BookSearchType::BOOK_GENRE, $operatorString, $queryString)
                        ->orWhere(BookSearchType::BOOK_TITLE, $operatorString, $queryString);
                });
            }
        }

        //ORDER BY
        if ($orderBy == 'title') {
            $books = $books->orderBy('title');
        }
        if ($orderBy == 'author') {
            $books = $books->orderBy('author.name');
        }
        if ($orderBy == 'subtitle') {
            $books = $books->orderBy('book.subtitle');
        }
        if ($orderBy == 'rating') {
            $books = $books->orderBy('personal_book_info.rating', 'DESC');
        }

        $books = $books->orderBy('author.name');
        $books = $books->orderBy('author.firstname');
        $books = $books->orderBy('date.year', 'ASC');
        $books = $books->orderBy('date.month', 'ASC');
        $books = $books->orderBy('date.day', 'ASC');


        list($totalValue, $totalAmountOfBooks, $totalAmountOfBooksOwned) = $this->getCollectionInformation($books);

        return new FilteredBooksResult($totalAmountOfBooks, $totalAmountOfBooksOwned, $totalValue, $books->paginate(self::PAGES));
    }

    public function getTotalAmountOfBooksRead()
    {
        return $this->bookRepository->getTotalAmountOfBooksRead();
    }

    public function getTotalAmountOfBooksBought()
    {
        return $this->bookRepository->getTotalAmountOfBooksBought();
    }

    public function getAllTranslators(){
        return $this->bookRepository->getAllTranslators();
    }

    /**
     * @param $books
     * @return array
     */
    public function getCollectionInformation($books)
    {
        $totalValue = $books->sum('book.retail_price');
        $totalAmountOfBooks = $books->count();
        $totalAmountOfBooksOwned = $books->where('personal_book_info.owned', '=', 1)->count();
        return array($totalValue, $totalAmountOfBooks, $totalAmountOfBooksOwned);
    }

    public function deleteBook($id)
    {
        $book = $this->bookRepository->find($id);

        if($book == null){
            throw new ServiceException("Book to delete not found");
        }

        $this->bookRepository->delete($book);
    }

    /**
     * @param CreateBookRequest $createRequest
     * @return array
     */
    private function mapTags(CreateBookRequest $createRequest)
    {
        if($createRequest->getTags() == null){
            return array();
        }
        $tagsAsStrings = array_map(function ($item) {
            return $item->getText();
        }, $createRequest->getTags());
        return $tagsAsStrings;
    }

    /**
     * @param CreateBookRequest $createBook
     * @return Date
     */
    private function createPublicationDate(CreateBookRequest $createBook)
    {
        $date = new Date();
        $date->day = $createBook->getPublicationDate()->getDay();
        $date->month = $createBook->getPublicationDate()->getDay();
        $date->year = $createBook->getPublicationDate()->getYear();
        $date->save();
        return $date;
    }
}