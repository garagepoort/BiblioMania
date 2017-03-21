<?php

class FirstPrintInfoServiceUpdateTest extends TestCase
{
    const USER_ID = 123;
    const FIRST_PRINT_INFO_ID = 1234;
    const COUNTRY_ID = 43;
    const LANGUAGE_ID = 65;
    const PUBLISHER_ID = 89;
    const PUBLICATION_DATE_ID = 594;

    /** @var FirstPrintInfoService $firstPrintInfoService */
    private $firstPrintInfoService;

    /** @var UpdateFirstPrintInfoRequestTestImpl $updateFirstPrintInfoRequestTestImpl */
    private $updateFirstPrintInfoRequestTestImpl;

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

    /** @var Publisher $publisher */
    private $publisher;
    /** @var Language $language */
    private $language;
    /** @var Country $country */
    private $country;
    /** @var Date $publicationDate */
    private $publicationDate;
    /** @var FirstPrintInfo $firstPrintInfo */
    private $firstPrintInfo;

    public function setUp(){
        parent::setUp();
        $this->firstPrintInfo = new FirstPrintInfo();
        $this->firstPrintInfo->id = self::FIRST_PRINT_INFO_ID;
        $this->firstPrintInfo->title = 'oldTitle';
        $this->firstPrintInfo->subtitle = 'oldSubtitle';
        $this->firstPrintInfo->ISBN = 'oldISBN';
        $this->firstPrintInfo->country_id = 231;
        $this->firstPrintInfo->language_id = 98;
        $this->firstPrintInfo->publisher_id = 1;
        $this->firstPrintInfo->publication_date_id = 23;

        $this->updateFirstPrintInfoRequestTestImpl = new UpdateFirstPrintInfoRequestTestImpl();

        $this->firstPrintInfoRepository = $this->mock('FirstPrintInfoRepository');
        $this->publisherService = $this->mock('PublisherService');
        $this->dateService = $this->mock('DateService');
        $this->languageService = $this->mock('LanguageService');
        $this->countryService = $this->mock('CountryService');

        $this->publisher = $this->mockEloquent('Publisher');
        $this->language = $this->mockEloquent('Language');
        $this->country = $this->mockEloquent('Country');
        $this->publicationDate = $this->mockEloquent('Date');

        $this->publisher->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLISHER_ID);
        $this->country->shouldReceive('getAttribute')->with('id')->andReturn(self::COUNTRY_ID);
        $this->language->shouldReceive('getAttribute')->with('id')->andReturn(self::LANGUAGE_ID);
        $this->publicationDate->shouldReceive('getAttribute')->with('id')->andReturn(self::PUBLICATION_DATE_ID);

        $this->firstPrintInfoService = App::make('FirstPrintInfoService');

        $this->firstPrintInfoRepository->shouldReceive('find')->with($this->updateFirstPrintInfoRequestTestImpl->getId())->andReturn($this->firstPrintInfo)->byDefault();
        $this->firstPrintInfoRepository->shouldReceive('save')->with($this->firstPrintInfo)->byDefault();
        $this->publisherService->shouldReceive('findOrCreate')->with(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl->getPublisher())->andReturn($this->publisher)->byDefault();
        $this->languageService->shouldReceive('findOrCreate')->with($this->updateFirstPrintInfoRequestTestImpl->getLanguage())->andReturn($this->language)->byDefault();
        $this->countryService->shouldReceive('findOrCreate')->with($this->updateFirstPrintInfoRequestTestImpl->getCountry())->andReturn($this->country)->byDefault();
        $this->dateService->shouldReceive('create')->with($this->updateFirstPrintInfoRequestTestImpl->getPublicationDate())->andReturn($this->publicationDate)->byDefault();
    }

    public function test_createsFirstPrintInfoCorrectly(){
        $this->firstPrintInfoRepository->shouldReceive('save')->once()->with(Mockery::type('FirstPrintInfo'));

        /** @var FirstPrintInfo $updatedFirstPrintInfo */
        $updatedFirstPrintInfo = $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);

        $this->assertEquals($this->updateFirstPrintInfoRequestTestImpl->getTitle(), $updatedFirstPrintInfo->title);
        $this->assertEquals($this->updateFirstPrintInfoRequestTestImpl->getSubtitle(), $updatedFirstPrintInfo->subtitle);
        $this->assertEquals($this->updateFirstPrintInfoRequestTestImpl->getIsbn(), $updatedFirstPrintInfo->ISBN);
        $this->assertEquals(self::COUNTRY_ID, $updatedFirstPrintInfo->country_id);
        $this->assertEquals(self::LANGUAGE_ID, $updatedFirstPrintInfo->language_id);
        $this->assertEquals(self::PUBLISHER_ID, $updatedFirstPrintInfo->publisher_id);
        $this->assertEquals(self::PUBLICATION_DATE_ID, $updatedFirstPrintInfo->publication_date_id);
    }

    /**
     * @expectedException Bendani\PhpCommon\Utils\Exception\ServiceException
     * @expectedExceptionMessage Object first print info to update can not be null.
     */
    public function test_throwsExceptionWhenFirstPrintInfoToUpdateNotFound(){
        $this->firstPrintInfoRepository->shouldReceive('find')->with($this->updateFirstPrintInfoRequestTestImpl->getId())->andReturn(null);

        $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);
    }
    

    public function test_setCountryToNullWhenNoCountryGiven(){
        $this->countryService->shouldReceive('findOrCreate')->never();
        $this->updateFirstPrintInfoRequestTestImpl->setCountry(null);

        /** @var FirstPrintInfo $updatedFirstPrintInfo */
        $updatedFirstPrintInfo = $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);

        $this->assertNull($updatedFirstPrintInfo->country_id);
    }

    public function test_setLanguageToNullWhenNoLanguageGiven(){
        $this->languageService->shouldReceive('findOrCreate')->never();
        $this->updateFirstPrintInfoRequestTestImpl->setLanguage(null);

        /** @var FirstPrintInfo $updatedFirstPrintInfo */
        $updatedFirstPrintInfo = $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);

        $this->assertNull($updatedFirstPrintInfo->language_id);
    }

    public function test_setsPublisherToNullWhenNoPublisherGiven(){
        $this->publisherService->shouldReceive('findOrCreate')->never();
        $this->updateFirstPrintInfoRequestTestImpl->setPublisher(null);

        /** @var FirstPrintInfo $updatedFirstPrintInfo */
        $updatedFirstPrintInfo = $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);

        $this->assertNull($updatedFirstPrintInfo->publisher_id);
    }

    public function test_setsPublicationDateToNullWhenNoPublicationDateGiven(){
        $this->dateService->shouldReceive('create')->never();
        $this->updateFirstPrintInfoRequestTestImpl->setPublicationDate(null);

        /** @var FirstPrintInfo $updatedFirstPrintInfo */
        $updatedFirstPrintInfo = $this->firstPrintInfoService->updateFirstPrintInfo(self::USER_ID, $this->updateFirstPrintInfoRequestTestImpl);

        $this->assertNull($updatedFirstPrintInfo->publication_date_id);
    }

}