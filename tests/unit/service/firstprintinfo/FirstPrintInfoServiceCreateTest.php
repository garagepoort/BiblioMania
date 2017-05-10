<?php

class FirstPrintInfoServiceCreateTest extends TestCase
{
    const USER_ID = 123;
    const COUNTRY_ID = 43;
    const LANGUAGE_ID = 65;
    const PUBLISHER_ID = 89;
    const PUBLICATION_DATE_ID = 594;

    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;

    /** @var CreateFirstPrintInfoRequestTestImpl $createFirstPrintInfoRequestTestImpl */
    private $createFirstPrintInfoRequestTestImpl;

    /** @var FirstPrintInfoRepository $firstPrintInfoRepository */
    private $firstPrintInfoRepository;
    /** @var PublisherService $publisherService */
    private $publisherService;
    /** @var LanguageService $languageService */
    private $languageService;
    /** @var CountryService $countryService */
    private $countryService;
    /** @var DateService $dateService */
    private $dateService;
    /** @var BookRepository $bookRepository */

    private $bookRepository;
    /** @var Publisher $publisher */
    private $publisher;
    /** @var Language $language */
    private $language;
    /** @var Country $country */
    private $country;
    /** @var Book $book */
    private $book;
    /** @var Date $publicationDate */
    private $publicationDate;

    public function setUp(){
        parent::setUp();
        $this->createFirstPrintInfoRequestTestImpl = new CreateFirstPrintInfoRequestTestImpl();

        $this->firstPrintInfoRepository = $this->mock('FirstPrintInfoRepository');
        $this->publisherService = $this->mock('PublisherService');
        $this->dateService = $this->mock('DateService');
        $this->languageService = $this->mock('LanguageService');
        $this->countryService = $this->mock('CountryService');
        $this->bookRepository = $this->mock('BookRepository');

        $this->book = $this->mockEloquent('Book');
        $this->publisher = $this->mockEloquent('Publisher');
        $this->language = $this->mockEloquent('Language');
        $this->country = $this->mockEloquent('Country');
        $this->publicationDate = $this->mockEloquent('Date');

        $this->publisher->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLISHER_ID);
        $this->country->shouldReceive('getAttribute')->with('id')->andReturn(self::COUNTRY_ID);
        $this->language->shouldReceive('getAttribute')->with('id')->andReturn(self::LANGUAGE_ID);
        $this->publicationDate->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLICATION_DATE_ID);

        $this->firstPrintInfoService = App::make('FirstPrintInfoService');

        $this->firstPrintInfoRepository->shouldReceive('save')->with(Mockery::type('FirstPrintInfo'))->byDefault();
        $this->publisherService->shouldReceive('findOrCreate')->with($this->createFirstPrintInfoRequestTestImpl->getPublisher())->andReturn($this->publisher)->byDefault();
        $this->languageService->shouldReceive('findOrCreate')->with($this->createFirstPrintInfoRequestTestImpl->getLanguage())->andReturn($this->language)->byDefault();
        $this->countryService->shouldReceive('findOrCreate')->with($this->createFirstPrintInfoRequestTestImpl->getCountry())->andReturn($this->country)->byDefault();
        $this->dateService->shouldReceive('create')->with($this->createFirstPrintInfoRequestTestImpl->getPublicationDate())->andReturn($this->publicationDate)->byDefault();
        $this->bookRepository->shouldReceive('find')->with($this->createFirstPrintInfoRequestTestImpl->getBookIdToLink())->andReturn($this->book)->byDefault();
        $this->bookRepository->shouldReceive('save')->with($this->book)->byDefault();
    }

    public function test_createsFirstPrintInfoCorrectly(){
        $this->book->shouldReceive('setAttribute')->with('first_print_info_id', Mockery::any())->once();
        $this->firstPrintInfoRepository->shouldReceive('save')->once()->with(Mockery::type('FirstPrintInfo'));
        $this->bookRepository->shouldReceive('save')->once()->with($this->book);

        /** @var FirstPrintInfo $createdFirstPrintInfo */
        $createdFirstPrintInfo = $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);

        $this->assertEquals($this->createFirstPrintInfoRequestTestImpl->getTitle(), $createdFirstPrintInfo->title);
        $this->assertEquals($this->createFirstPrintInfoRequestTestImpl->getSubtitle(), $createdFirstPrintInfo->subtitle);
        $this->assertEquals($this->createFirstPrintInfoRequestTestImpl->getIsbn(), $createdFirstPrintInfo->ISBN);
        $this->assertEquals(self::COUNTRY_ID, $createdFirstPrintInfo->country_id);
        $this->assertEquals(self::LANGUAGE_ID, $createdFirstPrintInfo->language_id);
        $this->assertEquals(self::PUBLISHER_ID, $createdFirstPrintInfo->publisher_id);
        $this->assertEquals(self::PUBLICATION_DATE_ID, $createdFirstPrintInfo->publication_date_id);
    }

    public function test_doesNotLinkToBookWhenBookIdNotGiven(){
        $this->book->shouldReceive('setAttribute')->with('first_print_info_id', Mockery::any())->never();
        $this->bookRepository->shouldReceive('find')->never();
        $this->bookRepository->shouldReceive('save')->never();
        $this->createFirstPrintInfoRequestTestImpl->setBookIdToLink(null);

        $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object book to link can not be null.
     */
    public function test_throwsExceptionWhenBookToLinkToNotFound(){
        $this->bookRepository->shouldReceive('find')->with($this->createFirstPrintInfoRequestTestImpl->getBookIdToLink())->andReturn(null);
        $this->bookRepository->shouldReceive('save')->never();

        $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);
    }


    public function test_doesNotCreateCountryWhenNoCountryGiven(){
        $this->countryService->shouldReceive('findOrCreate')->never();
        $this->createFirstPrintInfoRequestTestImpl->setCountry(null);

        $createdFirstPrintInfo = $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);

        $this->assertNull($createdFirstPrintInfo->country_id);
    }

    public function test_doesNotCreateLanguageWhenNoLanguageGiven(){
        $this->languageService->shouldReceive('findOrCreate')->never();
        $this->createFirstPrintInfoRequestTestImpl->setLanguage(null);

        $createdFirstPrintInfo = $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);

        $this->assertNull($createdFirstPrintInfo->language_id);
    }

    public function test_doesNotCreatePublisherWhenNoPublisherGiven(){
        $this->publisherService->shouldReceive('findOrCreate')->never();
        $this->createFirstPrintInfoRequestTestImpl->setPublisher(null);

        $createdFirstPrintInfo = $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);

        $this->assertNull($createdFirstPrintInfo->publisher_id);
    }

    public function test_doesNotCreatePublicationDateWhenNoPublicationDateGiven(){
        $this->dateService->shouldReceive('create')->never();
        $this->createFirstPrintInfoRequestTestImpl->setPublicationDate(null);

        $createdFirstPrintInfo = $this->firstPrintInfoService->createFirstPrintInfo(self::USER_ID, $this->createFirstPrintInfoRequestTestImpl);

        $this->assertNull($createdFirstPrintInfo->publication_date_id);
    }

}