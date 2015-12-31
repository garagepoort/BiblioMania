<?php

class BookServiceCreateTest extends TestCase
{
    const BOOK_ID = 123;
    const SAVED_IMAGE = 'savedImage';

    /** @var  BookService */
    private $bookService;
    /** @var  BookRepository */
    private $bookRepository;
    /** @var GenreService $genreService */
    private $genreService;
    /** @var PublisherService $publisherService */
    private $publisherService;
    /** @var LanguageService $languageService*/
    private $languageService;
    /** @var PublisherSerieService $publisherSerieService */
    private $publisherSerieService;
    /** @var CountryService $countryService */
    private $countryService;
    /** @var AuthorService $authorService */
    private $authorService;
    /** @var BookSerieService $bookSerieService */
    private $bookSerieService;
    /** @var DateService $dateService */
    private $dateService;
    /** @var ImageService $imageService */
    private $imageService;

    /** @var  Genre $genre */
    private $genre;
    /** @var  Author $author */
    private $author;
    /** @var  Publisher $publisher */
    private $publisher;
    /** @var  Country $country */
    private $country;
    /** @var  Language $language */
    private $language;
    /** @var  Date $publicationDate */
    private $publicationDate;
    /** @var  CreateBookRequestTestImpl $createBookRequestImpl */
    private $createBookRequestImpl;

    private $WITH_ARRAY = array('bla', 'oim');

    public function setUp()
    {
        parent::setUp();
        $this->createBookRequestImpl = new CreateBookRequestTestImpl();

        $this->bookRepository = $this->mock('BookRepository');
        $this->authorService = $this->mock('AuthorService');
        $this->genreService = $this->mock('GenreService');
        $this->publisherService = $this->mock('PublisherService');
        $this->languageService = $this->mock('LanguageService');
        $this->publisherSerieService = $this->mock('PublisherSerieService');
        $this->bookSerieService = $this->mock('BookSerieService');
        $this->countryService = $this->mock('CountryService');
        $this->dateService = $this->mock('DateService');
        $this->imageService = $this->mock('ImageService');

        $this->genre = $this->mockEloquent('Genre');
        $this->author = $this->mockEloquent('Author');
        $this->publisher = $this->mockEloquent('Publisher');
        $this->country = $this->mockEloquent('Country');
        $this->language = $this->mockEloquent('Language');
        $this->publicationDate = $this->mockEloquent('Date');

        $this->genreService->shouldReceive('getGenreByName')->once()
            ->with($this->createBookRequestImpl->getGenre())
            ->andReturn($this->genre)->byDefault();
        $this->authorService->shouldReceive('find')->once()
            ->with($this->createBookRequestImpl->getPreferredAuthorId())
            ->andReturn($this->author)->byDefault();

        $this->bookService = App::make('BookService');
    }

//    public function test_shouldSaveBookCorrectly(){
//        $this->publisherService->shouldReceive('findOrCreate')->once()
//            ->with($this->createBookRequestImpl->getPublisher())
//            ->andReturn($this->publisher);
//
//        $this->countryService->shouldReceive('findOrCreate')->once()
//            ->with($this->createBookRequestImpl->getCountry())
//            ->andReturn($this->country);
//
//        $this->languageService->shouldReceive('findOrCreate')->once()
//            ->with($this->createBookRequestImpl->getLanguage())
//            ->andReturn($this->language);
//
//        $this->dateService->shouldReceive('create')->once()
//            ->with($this->createBookRequestImpl->getPublicationDate())
//            ->andReturn($this->publicationDate);
//
//        $this->imageService->shouldReceive('saveBookImageFromUrl')->once()
//            ->with($this->createBookRequestImpl->getImageUrl(), Mockery::any())
//            ->andReturn(self::SAVED_IMAGE);
//
//        $foundBook = $this->bookService->create($this->createBookRequestImpl);
//    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object Genre can not be null.
     */
    public function test_shouldThrowExceptionWhenGenreNotFound()
    {
        $this->genreService->shouldReceive('getGenreByName')->once()
            ->with($this->createBookRequestImpl->getGenre())
            ->andReturn(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object Author can not be null.
     */
    public function test_shouldThrowExceptionWhenPreferredAuthorNotFound()
    {
        $this->authorService->shouldReceive('find')->once()
            ->with($this->createBookRequestImpl->getPreferredAuthorId())
            ->andReturn(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Object PublicationDate can not be null.
     */
    public function test_shouldThrowExceptionWhenPublicationDateIsNull()
    {
        $this->createBookRequestImpl->setPublicationDate(null);

        $this->bookService->create($this->createBookRequestImpl);
    }
    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field PublicationDate year can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublicationDateYearIsEmpty()
    {
        $publicationDate = new DateRequestTestImpl();
        $publicationDate->setYear('');
        $this->createBookRequestImpl->setPublicationDate($publicationDate);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field PublicationDate year can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublicationDateYearIsNull()
    {
        $publicationDate = new DateRequestTestImpl();
        $publicationDate->setYear(null);
        $this->createBookRequestImpl->setPublicationDate($publicationDate);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Language can not be empty.
     */
    public function test_shouldThrowExceptionWhenLanguageIsNull()
    {
        $this->createBookRequestImpl->setLanguage(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Language can not be empty.
     */
    public function test_shouldThrowExceptionWhenLanguageIsEmpty()
    {
        $this->createBookRequestImpl->setLanguage('  ');

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Title can not be empty.
     */
    public function test_shouldThrowExceptionWhenTitleIsNull()
    {
        $this->createBookRequestImpl->setTitle(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Title can not be empty.
     */
    public function test_shouldThrowExceptionWhenTitleIsEmpty()
    {
        $this->createBookRequestImpl->setTitle('  ');

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Publisher can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublisherIsNull()
    {
        $this->createBookRequestImpl->setPublisher(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Publisher can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublisherIsEmpty()
    {
        $this->createBookRequestImpl->setPublisher('  ');

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Country can not be empty.
     */
    public function test_shouldThrowExceptionWhenCountryIsNull()
    {
        $this->createBookRequestImpl->setCountry(null);

        $this->bookService->create($this->createBookRequestImpl);
    }

    /**
     * @expectedException ServiceException
     * @expectedExceptionMessage Field Country can not be empty.
     */
    public function test_shouldThrowExceptionWhenCountryIsEmpty()
    {
        $this->createBookRequestImpl->setCountry('  ');

        $this->bookService->create($this->createBookRequestImpl);
    }


}
