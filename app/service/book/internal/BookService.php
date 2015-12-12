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
    /** @var LoggingService */
    private $loggingService;

    function __construct()
    {
        $this->loggingService = App::make('LoggingService');
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

    public function allBooksFromUser($userId){
        return $this->bookRepository->allFromUser($userId, array('authors'));
    }

    public function create(BaseBookRequest $createBookRequest){
        $book = new Book();
        return $this->saveBook($createBookRequest, $book);
    }

    public function update(UpdateBookRequest $updateBookRequest){
        $book = $this->bookRepository->find($updateBookRequest->getId());
        Ensure::objectNotNull('book', $book);

        return $this->saveBook($updateBookRequest, $book);
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
            ->leftJoin("reading_date", "personal_book_info_reading_date.reading_date_id", "=", "reading_date.id");

        foreach($filters as $filter){
            $books = $this->bookFilterManager->handle($filter['id'], $books, $filter['value'], $filter['operator']);
        }

        $books = $books->groupBy('book.id');
        $books = $books->orderBy('author.name');
        $books = $books->orderBy('author.firstname');
        $books = $books->orderBy('date.year', 'ASC');
        $books = $books->orderBy('date.month', 'ASC');
        $books = $books->orderBy('date.day', 'ASC');

        $this->loggingService->logInfo($books->toSql());

        return $books->get();
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
     * @param BaseBookRequest $createRequest
     * @return array
     */
    private function mapTags(BaseBookRequest $createRequest)
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
     * @param BaseBookRequest $createBook
     * @return Date
     */
    private function createPublicationDate(BaseBookRequest $createBook)
    {
        $date = new Date();
        $date->day = $createBook->getPublicationDate()->getDay();
        $date->month = $createBook->getPublicationDate()->getDay();
        $date->year = $createBook->getPublicationDate()->getYear();
        $date->save();
        return $date;
    }

    /**
     * @param BaseBookRequest $createBookRequest
     * @param $book
     * @return mixed
     */
    private function saveBook(BaseBookRequest $createBookRequest, $book)
    {
        return DB::transaction(function () use ($book, $createBookRequest) {
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

            $book->serie_id = null;
            $book->publisher_serie_id = null;

            if (!StringUtils::isEmpty($createBookRequest->getSerie())) {
                $bookSerie = $this->bookSerieService->findOrSave($createBookRequest->getSerie());
                $book->serie_id = $bookSerie->id;
            }

            if (!StringUtils::isEmpty($createBookRequest->getPublisherSerie())) {
                $bookSerie = $this->publisherSerieService->findOrSave($createBookRequest->getPublisherSerie(), $bookPublisher->id);
                $book->publisher_serie_id = $bookSerie->id;
            }

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
            $book->translator = $createBookRequest->getTranslator();
            $book->print = $createBookRequest->getPrint();
            $book->number_of_pages = $createBookRequest->getPages();

            if (!StringUtils::isEmpty($createBookRequest->getImageUrl())) {
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

}