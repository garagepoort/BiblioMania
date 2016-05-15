<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Bendani\PhpCommon\Utils\StringUtils;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

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
    /** @var  ImageService */
    private $imageService;
    /** @var  TagService */
    private $tagService;
    /** @var  TagRepository */
    private $tagRepository;
    /** @var  LanguageService */
    private $languageService;
    /** @var  AuthorService */
    private $authorService;
    /** @var AuthorRepository $authorRepository */
    private $authorRepository;
    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var BookFilterManager $bookFilterManager */
    private $bookFilterManager;
    /** @var GenreService */
    private $genreService;
    /** @var DateService */
    private $dateService;
    /** @var FilterHistoryService */
    private $filterHistoryService;
    /** @var BookElasticIndexer */
    private $bookElasticIndexer;

    function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->publisherSerieService = App::make('PublisherSerieService');
        $this->bookSerieService = App::make('BookSerieService');
        $this->imageService = App::make('ImageService');
        $this->tagService = App::make('TagService');
        $this->tagRepository = App::make('TagRepository');
        $this->languageService = App::make('LanguageService');
        $this->authorService = App::make('AuthorService');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->bookFilterManager = App::make('BookFilterManager');
        $this->genreService = App::make('GenreService');
        $this->filterHistoryService = App::make('FilterHistoryService');
        $this->dateService = App::make('DateService');
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
        $this->authorRepository = App::make('AuthorRepository');
    }

    public function find($id, $with = array())
    {
        return $this->bookRepository->find($id, $with);
    }

    public function allBooks(){
        return $this->bookRepository->allWith(array('personal_book_infos', 'authors', 'book_from_authors'));
    }

    public function create($userId, BaseBookRequest $createBookRequest){
        $book = new Book();
        return $this->saveBook($userId, $createBookRequest, $book);
    }

    public function update($userId, UpdateBookRequest $updateBookRequest){
        $book = $this->bookRepository->find($updateBookRequest->getId());
        Ensure::objectNotNull('book', $book);

        return $this->saveBook($userId, $updateBookRequest, $book);
    }

    public function getBooksByAuthor($authorId){
        return $this->bookRepository->booksFromAuthor($authorId);
    }

    public function linkAuthorToBook($bookId, LinkAuthorToBookRequest $authorToBookRequest){
        /** @var Book $book */
        $book = $this->find($bookId);
        Ensure::objectNotNull('book', $book);
        $author = $this->authorRepository->find($authorToBookRequest->getAuthorId());
        Ensure::objectNotNull('author', $author);

        $this->bookRepository->addAuthorToBook($book, $authorToBookRequest->getAuthorId());
    }

    public function unlinkAuthorFromBook($bookId, UnlinkAuthorFromBookRequest $unlinkAuthorFromBookRequest){
        /** @var Book $book */
        $book = $this->find($bookId);
        Ensure::objectNotNull('book', $book);
        $author = $this->authorRepository->findByBook($book, $unlinkAuthorFromBookRequest->getAuthorId());
        Ensure::objectNotNull('author', $author);

        if($author->pivot->preferred){
            throw new ServiceException('Preferred author cannot be unlinked from book.');
        }

        $this->bookRepository->removeAuthorFromBook($book, $unlinkAuthorFromBookRequest->getAuthorId());
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
        return $this->bookRepository->allWith(array('personal_book_infos'));
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
            'book_from_authors',
            'country',
            'publisher_serie',
            'serie');

        return $this->bookRepository->find($book_id, $with);
    }

    public function searchAllBooks($filters){
        $this->filterHistoryService->addFiltersToHistory($filters);

        list($personalFiltersForSearch, $filtersForSearch) = $this->filtersToFilterHandlers($filters);

        if(count($personalFiltersForSearch) > 0){
            array_push($filtersForSearch, FilterBuilder::terms('personalBookInfoUsers', [Auth::user()->id]));
        }

        return $this->bookElasticIndexer->search(Auth::user()->id, $filtersForSearch, $personalFiltersForSearch);
    }

    public function searchOtherBooks($filters){
        $this->filterHistoryService->addFiltersToHistory($filters);

        list($personalFiltersForSearch, $filtersForSearch) = $this->filtersToFilterHandlers($filters);

        array_push($filtersForSearch, FilterBuilder::notTerms('personalBookInfoUsers', [Auth::user()->id]));

        return $this->bookElasticIndexer->search(Auth::user()->id, $filtersForSearch, $personalFiltersForSearch);
    }

    public function searchMyBooks($filters){
        $this->filterHistoryService->addFiltersToHistory($filters);

        list($personalFiltersForSearch, $filtersForSearch) = $this->filtersToFilterHandlers($filters);

        array_push($filtersForSearch, FilterBuilder::terms('personalBookInfoUsers', [Auth::user()->id]));

        return $this->bookElasticIndexer->search(Auth::user()->id, $filtersForSearch, $personalFiltersForSearch);
    }

    public function searchWishlist($filters){
        $this->filterHistoryService->addFiltersToHistory($filters);

        list($personalFiltersForSearch, $filtersForSearch) = $this->filtersToFilterHandlers($filters);

        array_push($filtersForSearch, FilterBuilder::terms('wishlistUsers', [Auth::user()->id]));

        return $this->bookElasticIndexer->search(Auth::user()->id, $filtersForSearch, $personalFiltersForSearch);
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
        $this->bookElasticIndexer->deleteBook($book);
    }

    /**
     * @param BaseBookRequest $createBookRequest
     * @param $book
     * @return mixed
     */
    private function saveBook($userId, BaseBookRequest $createBookRequest, $book)
    {
        return DB::transaction(function () use ($userId, $book, $createBookRequest) {
            $genre = $this->genreService->getGenreByName($createBookRequest->getGenre());
            $author = $this->authorService->find($createBookRequest->getPreferredAuthorId());

            Ensure::objectNotNull("Book", $book);
            Ensure::objectNotNull("Author", $author);
            Ensure::objectNotNull("Genre", $genre);
            Ensure::objectNotNull("PublicationDate", $createBookRequest->getPublicationDate());
            Ensure::stringNotBlank("PublicationDate year", $createBookRequest->getPublicationDate()->getYear());
            Ensure::stringNotBlank("Language", $createBookRequest->getLanguage());
            Ensure::stringNotBlank("Title", $createBookRequest->getTitle());
            Ensure::stringNotBlank("Isbn", $createBookRequest->getIsbn());
            Ensure::stringNotBlank("Publisher", $createBookRequest->getPublisher());
            Ensure::stringNotBlank("Country", $createBookRequest->getCountry());

            $bookPublisher = $this->publisherService->findOrCreate($userId, $createBookRequest->getPublisher());
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

            $language = $this->languageService->findOrCreate($createBookRequest->getLanguage());
            $publicationDate = $this->dateService->create($createBookRequest->getPublicationDate());

            $book->title = $createBookRequest->getTitle();
            $book->subtitle = $createBookRequest->getSubtitle();
            $book->ISBN = $createBookRequest->getIsbn();
            $book->publication_date_id = $publicationDate->id;
            $book->language_id = $language->id;
            $book->genre_id = $genre->id;
            $book->publisher_id = $bookPublisher->id;
            $book->publisher_country_id = $country->id;
            $book->translator = $createBookRequest->getTranslator();
            $book->print = $createBookRequest->getPrint();
            $book->number_of_pages = $createBookRequest->getPages();
            $book->summary = $createBookRequest->getSummary();

            $book->retail_price = $createBookRequest->getRetailPrice()->getAmount();
            $book->currency = $createBookRequest->getRetailPrice()->getCurrency();

            if (!StringUtils::isEmpty($createBookRequest->getImageUrl())) {
                $book->coverImage = $this->imageService->saveBookImageFromUrl($createBookRequest->getImageUrl(), $book);
            }

            $this->bookRepository->save($book);

            $this->saveTags($createBookRequest, $book);
            $this->authorService->syncAuthors($author, [], $book);

            $this->bookElasticIndexer->indexBook($book);
            return $book;
        });
    }

    /**
     * @param $createBookRequest
     * @param $book
     */
    private function saveTags($createBookRequest, $book)
    {
        $tagsAsStrings = $this->mapTags($createBookRequest);
        $createdTagIds = $this->tagService->createTags($tagsAsStrings);
        $this->tagRepository->syncTagsWithBook($book, $createdTagIds);
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
            Ensure::stringNotBlank('tag', $item->getText());
            return $item->getText();
        }, $createRequest->getTags());
        return $tagsAsStrings;
    }

    /**
     * @param $filters
     * @return array
     */
    private function filtersToFilterHandlers($filters)
    {
        $personalFiltersForSearch = [];
        $filtersForSearch = [];
        /** @var FilterValue $filterValue */
        foreach ($filters as $filterValue) {
            /** @var Filter $filter */
            $filter = $this->bookFilterManager->getFilter($filterValue->getId());

            if ($filter->getGroup() === 'personal') {
                array_push($personalFiltersForSearch, $this->bookFilterManager->handle(FilterHandlerGroup::ELASTIC, $filterValue));
            } else {
                array_push($filtersForSearch, $this->bookFilterManager->handle(FilterHandlerGroup::ELASTIC, $filterValue));
            }
        }
        return array($personalFiltersForSearch, $filtersForSearch);
    }

}