<?php

use Bendani\PhpCommon\Utils\Exception\ServiceException;

class BookServiceCreateTest extends TestCase
{
    const USER_ID = 3231;
    const BOOK_ID = 123;
    const GENRE_ID = 5432;
    const PUBLICATION_DATE_ID = 837;
    const LANGUAGE_ID = 63826;
    const COUNTRY_ID = 328947;
    const PUBLISHER_ID = 374298;

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
    /** @var TagRepository $tagRepository */
    private $tagRepository;
    /** @var BookElasticIndexer $bookElasticIndexer */
    private $bookElasticIndexer;

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
        $this->tagRepository = $this->mock('TagRepository');
        $this->bookElasticIndexer = $this->mock('BookElasticIndexer');

        $this->genre = $this->mockEloquent('Genre');
        $this->genre->shouldReceive('getAttribute')->with("id")->andReturn(self::GENRE_ID);

        $this->author = $this->mockEloquent('Author');
        $this->publisher = $this->mockEloquent('Publisher');
        $this->publisher->shouldReceive('getAttribute')->with("id")->andReturn(self::PUBLISHER_ID);

        $this->country = $this->mockEloquent('Country');
        $this->country->shouldReceive('getAttribute')->with("id")->andReturn(self::COUNTRY_ID);

        $this->language = $this->mockEloquent('Language');
        $this->language->shouldReceive('getAttribute')->with("id")->andReturn(self::LANGUAGE_ID);

        $this->publicationDate = $this->mockEloquent('Date');
        $this->publicationDate->shouldReceive('getAttribute')->with("id")->andReturn(self::PUBLICATION_DATE_ID);

        $this->genreService->shouldReceive('getGenreByName')->once()
            ->with($this->createBookRequestImpl->getGenre())
            ->andReturn($this->genre)->byDefault();
        $this->authorService->shouldReceive('find')->once()
            ->with($this->createBookRequestImpl->getPreferredAuthorId())
            ->andReturn($this->author)->byDefault();

        $this->publisherService->shouldReceive('findOrCreate')->with(self::USER_ID, $this->createBookRequestImpl->getPublisher())->andReturn($this->publisher);
        $this->countryService->shouldReceive('findOrCreate')->with($this->createBookRequestImpl->getCountry())->andReturn($this->country);
        $this->languageService->shouldReceive('findOrCreate')->with($this->createBookRequestImpl->getLanguage())->andReturn($this->language);
        $this->dateService->shouldReceive('create')->with($this->createBookRequestImpl->getPublicationDate())->andReturn($this->publicationDate);

        $this->bookService = App::make('BookService');
    }

    public function test_shouldSaveBookCorrectly(){
        $this->createBookRequestImpl->setSerie(null);
        $this->createBookRequestImpl->setPublisherSerie(null);
        $this->createBookRequestImpl->setImageUrl(null);

        $this->imageService->shouldReceive('saveBookImageFromUrl')->never();
        $this->bookSerieService->shouldReceive('findOrSave')->never();
        $this->publisherSerieService->shouldReceive('findOrSave')->never();

        $this->bookRepository->shouldReceive('save')->once()->with(Mockery::any());
        $this->bookElasticIndexer->shouldReceive('indexBook')->once()->with(Mockery::any());

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);


        $this->assertEquals($createdBook->title, $this->createBookRequestImpl->getTitle());
        $this->assertEquals($createdBook->subtitle, $this->createBookRequestImpl->getSubtitle());
        $this->assertEquals($createdBook->ISBN, $this->createBookRequestImpl->getIsbn());
        $this->assertEquals($createdBook->publication_date_id, self::PUBLICATION_DATE_ID);
        $this->assertEquals($createdBook->publisher_id, self::PUBLISHER_ID);
        $this->assertEquals($createdBook->publisher_country_id, self::COUNTRY_ID);
        $this->assertEquals($createdBook->genre_id, self::GENRE_ID);
        $this->assertEquals($createdBook->translator, $this->createBookRequestImpl->getTranslator());
        $this->assertEquals($createdBook->print, $this->createBookRequestImpl->getPrint());
        $this->assertEquals($createdBook->number_of_pages, $this->createBookRequestImpl->getPages());
        $this->assertEquals($createdBook->retail_price, $this->createBookRequestImpl->getRetailPrice()->getAmount());
        $this->assertEquals($createdBook->currency, $this->createBookRequestImpl->getRetailPrice()->getCurrency());
        $this->assertNull($createdBook->coverImage);
        $this->assertNull($createdBook->serie_id);
        $this->assertNull($createdBook->publisher_serie_id);
    }

    public function test_shouldSaveBookSerieWhenSerieFilledIn(){
        $serieId = 9384;
        $serieString = 'bookSerie';
        $serie = $this->mockEloquent('Serie');
        $serie->shouldReceive('getAttribute')->with("id")->andReturn($serieId);
        $this->createBookRequestImpl->setSerie($serieString);
        $this->bookSerieService->shouldReceive('findOrSave')->once()->with($serieString)->andReturn($serie);

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertEquals($createdBook->serie_id, $serieId);
    }

    public function test_shouldNotSaveBookSerieWhenSerieBlank(){
        $serieId = 9384;
        $serieString = '  ';
        $serie = $this->mockEloquent('Serie');
        $serie->shouldReceive('getAttribute')->with("id")->andReturn($serieId);
        $this->createBookRequestImpl->setSerie($serieString);
        $this->bookSerieService->shouldReceive('findOrSave')->never();

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertNull($createdBook->serie_id);
    }


    public function test_shouldSavePublisherSerieWhenSerieFilledIn(){
        $serieId = 9384;
        $serieString = 'publisherSerie';
        $serie = $this->mockEloquent('PublisherSerie');
        $serie->shouldReceive('getAttribute')->with("id")->andReturn($serieId);
        $this->createBookRequestImpl->setPublisherSerie($serieString);
        $this->publisherSerieService->shouldReceive('findOrSave')->once()->with($serieString, self::PUBLISHER_ID)->andReturn($serie);

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertEquals($createdBook->publisher_serie_id, $serieId);
    }

    public function test_shouldNotSavePublisherSerieWhenSerieBlank(){
        $serieId = 9384;
        $serieString = '  ';
        $serie = $this->mockEloquent('PublisherSerie');
        $serie->shouldReceive('getAttribute')->with("id")->andReturn($serieId);
        $this->createBookRequestImpl->setPublisherSerie($serieString);
        $this->publisherSerieService->shouldReceive('findOrSave')->never();

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertNull($createdBook->publisher_serie_id);
    }

    public function test_shouldSaveImageWhenImageUrlFilledIn(){
        $imageUrl = 'imageurl';
        $savedImage = 'saveImaged';
        $this->createBookRequestImpl->setImageUrl($imageUrl);
        $this->imageService->shouldReceive('saveBookImageFromUrl')->once()->with($imageUrl, Mockery::any())->andReturn($savedImage);

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertEquals($createdBook->coverImage, $savedImage);
    }

    public function test_shouldNotSaveImageWhenImageUrlBlank(){
        $imageUrl = '   ';
        $this->createBookRequestImpl->setImageUrl($imageUrl);
        $this->imageService->shouldReceive('saveBookImageFromUrl')->never();

        $createdBook = $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);

        $this->assertNull($createdBook->coverImage);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object Genre can not be null.
     */
    public function test_shouldThrowExceptionWhenGenreNotFound()
    {
        $this->genreService->shouldReceive('getGenreByName')->once()
            ->with($this->createBookRequestImpl->getGenre())
            ->andReturn(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object Author can not be null.
     */
    public function test_shouldThrowExceptionWhenPreferredAuthorNotFound()
    {
        $this->authorService->shouldReceive('find')->once()
            ->with($this->createBookRequestImpl->getPreferredAuthorId())
            ->andReturn(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object PublicationDate can not be null.
     */
    public function test_shouldThrowExceptionWhenPublicationDateIsNull()
    {
        $this->createBookRequestImpl->setPublicationDate(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }
    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field PublicationDate year can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublicationDateYearIsEmpty()
    {
        $publicationDate = new DateRequestTestImpl();
        $publicationDate->setYear('');
        $this->createBookRequestImpl->setPublicationDate($publicationDate);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field PublicationDate year can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublicationDateYearIsNull()
    {
        $publicationDate = new DateRequestTestImpl();
        $publicationDate->setYear(null);
        $this->createBookRequestImpl->setPublicationDate($publicationDate);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Language can not be empty.
     */
    public function test_shouldThrowExceptionWhenLanguageIsNull()
    {
        $this->createBookRequestImpl->setLanguage(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Language can not be empty.
     */
    public function test_shouldThrowExceptionWhenLanguageIsEmpty()
    {
        $this->createBookRequestImpl->setLanguage('  ');

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Title can not be empty.
     */
    public function test_shouldThrowExceptionWhenTitleIsNull()
    {
        $this->createBookRequestImpl->setTitle(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Title can not be empty.
     */
    public function test_shouldThrowExceptionWhenTitleIsEmpty()
    {
        $this->createBookRequestImpl->setTitle('  ');

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Publisher can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublisherIsNull()
    {
        $this->createBookRequestImpl->setPublisher(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Publisher can not be empty.
     */
    public function test_shouldThrowExceptionWhenPublisherIsEmpty()
    {
        $this->createBookRequestImpl->setPublisher('  ');

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Country can not be empty.
     */
    public function test_shouldThrowExceptionWhenCountryIsNull()
    {
        $this->createBookRequestImpl->setCountry(null);

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Field Country can not be empty.
     */
    public function test_shouldThrowExceptionWhenCountryIsEmpty()
    {
        $this->createBookRequestImpl->setCountry('  ');

        $this->bookService->create(self::USER_ID, $this->createBookRequestImpl);
    }


}
