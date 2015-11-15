<?php

class BookBasicsService
{

    /** @var  PublisherService $publisherService */
    private $publisherService;
    /** @var  BookRepository $bookRepository*/
    private $bookRepository;
    /** @var  CountryService $countryService*/
    private $countryService;
    /** @var  TagService $tagService*/
    private $tagService;
    /** @var  LanguageService $languageService*/
    private $languageService;
    /** @var  GenreService $genreService*/
    private $genreService;

    public function __construct()
    {
        $this->bookRepository = App::make('BookRepository');
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->tagService = App::make('TagService');
        $this->languageService = App::make('LanguageService');
        $this->genreService = App::make('GenreService');
    }

    public function createBookBasics(BaseBookBasicsRequest $baseBookBasicsRequest){
        /** @var Book $book */
        $book = new Book();
        $book->user_id = Auth::user()->id;
        $this->saveBook($baseBookBasicsRequest, $book);
    }

    public function updateBookBasics(UpdateBookBasicsRequest $updateBookBasicsRequest){
        /** @var Book $book */
        $book = $this->bookRepository->find($updateBookBasicsRequest->getId());
        $this->saveBook($updateBookBasicsRequest, $book);
    }

    /**
     * @param BaseBookBasicsRequest $baseBookBasicsRequest
     * @param $book
     * @throws ServiceException
     */
    private function saveBook(BaseBookBasicsRequest $baseBookBasicsRequest, $book)
    {
        $genre = $this->genreService->getGenreByName($baseBookBasicsRequest->getGenre());

        Ensure::objectNotNull("Book", $book);
        Ensure::objectNotNull("Genre", $genre);
        Ensure::objectNotNull("PublicationDate", $baseBookBasicsRequest->getPublicationDate());
        Ensure::stringNotBlank("Language", $baseBookBasicsRequest->getLanguage());
        Ensure::stringNotBlank("Title", $baseBookBasicsRequest->getTitle());
        Ensure::stringNotBlank("Isbn", $baseBookBasicsRequest->getIsbn());
        Ensure::stringNotBlank("Publisher", $baseBookBasicsRequest->getPublisher());
        Ensure::stringNotBlank("Country", $baseBookBasicsRequest->getCountry());

        $bookPublisher = $this->publisherService->findOrCreate($baseBookBasicsRequest->getPublisher());
        $country = $this->countryService->findOrCreate($baseBookBasicsRequest->getCountry());
        $book->language()->associate($this->languageService->findOrSave($baseBookBasicsRequest->getLanguage()));

        $tagsAsStrings = $this->mapTags($baseBookBasicsRequest);
        $tags = $this->tagService->createTags($tagsAsStrings);

        $date = $this->createPublicationDate($baseBookBasicsRequest);
        $book->publication_date()->associate($date);

        $book->title = $baseBookBasicsRequest->getTitle();
        $book->subtitle = $baseBookBasicsRequest->getSubtitle();
        $book->ISBN = $baseBookBasicsRequest->getIsbn();
        $book->genre_id = $genre->id;
        $book->publisher_id = $bookPublisher->id;
        $book->publisher_country_id = $country->id;

        $this->bookRepository->save($book);
        $book->tags()->sync($tags);
    }

    /**
     * @param BaseBookBasicsRequest $baseBookBasicsRequest
     * @return array
     */
    private function mapTags(BaseBookBasicsRequest $baseBookBasicsRequest)
    {
        if($baseBookBasicsRequest->getTags() == null){
            return array();
        }
        $tagsAsStrings = array_map(function ($item) {
            return $item->getText();
        }, $baseBookBasicsRequest->getTags());
        return $tagsAsStrings;
    }

    /**
     * @param BaseBookBasicsRequest $baseBookBasicsRequest
     * @return Date
     */
    private function createPublicationDate(BaseBookBasicsRequest $baseBookBasicsRequest)
    {
        $date = new Date();
        $date->day = $baseBookBasicsRequest->getPublicationDate()->getDay();
        $date->month = $baseBookBasicsRequest->getPublicationDate()->getDay();
        $date->year = $baseBookBasicsRequest->getPublicationDate()->getYear();
        $date->save();
        return $date;
    }
}