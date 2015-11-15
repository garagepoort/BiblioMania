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


    public function updateBookBasics(UpdateBookBasicsRequest $updateBookBasicsRequest){
        /** @var Book $book */
        $book = $this->bookRepository->find($updateBookBasicsRequest->getId());
        $genre = $this->genreService->getGenreByName($updateBookBasicsRequest->getGenre());

        Ensure::objectNotNull("Book", $book);
        Ensure::objectNotNull("Genre", $genre);
        Ensure::objectNotNull("PublicationDate", $updateBookBasicsRequest->getPublicationDate());
        Ensure::stringNotBlank("Language", $updateBookBasicsRequest->getLanguage());
        Ensure::stringNotBlank("Title", $updateBookBasicsRequest->getTitle());
        Ensure::stringNotBlank("Isbn", $updateBookBasicsRequest->getIsbn());
        Ensure::stringNotBlank("Publisher", $updateBookBasicsRequest->getPublisher());
        Ensure::stringNotBlank("Country", $updateBookBasicsRequest->getCountry());

        $bookPublisher = $this->publisherService->findOrCreate($updateBookBasicsRequest->getPublisher());
        $country = $this->countryService->findOrCreate($updateBookBasicsRequest->getCountry());
        $book->language()->associate($this->languageService->findOrSave($updateBookBasicsRequest->getLanguage()));

        $tagsAsStrings = $this->mapTags($updateBookBasicsRequest);
        $tags = $this->tagService->createTags($tagsAsStrings);

        $date = $this->createPublicationDate($updateBookBasicsRequest);
        $book->publication_date()->associate($date);

        $book->title = $updateBookBasicsRequest->getTitle();
        $book->subtitle = $updateBookBasicsRequest->getSubtitle();
        $book->ISBN = $updateBookBasicsRequest->getIsbn();
        $book->genre_id = $genre->id;
        $book->publisher_id = $bookPublisher->id;
        $book->publisher_country_id = $country->id;

        $this->bookRepository->save($book);
        $book->tags()->sync($tags);
    }

    /**
     * @param UpdateBookBasicsRequest $updateBookBasicsRequest
     * @return array
     */
    private function mapTags(UpdateBookBasicsRequest $updateBookBasicsRequest)
    {
        $tagsAsStrings = array_map(function ($item) {
            return $item->getText();
        }, $updateBookBasicsRequest->getTags());
        return $tagsAsStrings;
    }

    /**
     * @param UpdateBookBasicsRequest $updateBookBasicsRequest
     * @return Date
     */
    private function createPublicationDate(UpdateBookBasicsRequest $updateBookBasicsRequest)
    {
        $date = new Date();
        $date->day = $updateBookBasicsRequest->getPublicationDate()->getDay();
        $date->month = $updateBookBasicsRequest->getPublicationDate()->getDay();
        $date->year = $updateBookBasicsRequest->getPublicationDate()->getYear();
        $date->save();
        return $date;
    }
}