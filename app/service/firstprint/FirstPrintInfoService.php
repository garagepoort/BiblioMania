<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Bendani\PhpCommon\Utils\StringUtils;

class FirstPrintInfoService
{

    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  FirstPrintInfoRepository */
    private $firstPrintInfoRepository;
    /** @var  BookRepository */
    private $bookRepository;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->languageService = App::make('LanguageService');
        $this->firstPrintInfoRepository = App::make('FirstPrintInfoRepository');
        $this->bookRepository = App::make('BookRepository');
    }

    public function createFirstPrintInfo(CreateFirstPrintInfoRequest $firstPrintInfoRequest){
        return DB::transaction(function() use ($firstPrintInfoRequest){
            $firstPrint = new FirstPrintInfo();
            $firstPrintInfo = $this->saveFirstPrintInfo($firstPrintInfoRequest, $firstPrint);

            if($firstPrintInfoRequest->getBookIdToLink() !== null){
                /** @var Book $book */
                $book = $this->bookRepository->find($firstPrintInfoRequest->getBookIdToLink());
                Ensure::objectNotNull('book to link', $book);
                $book->first_print_info_id = $firstPrintInfo->id;
                $book->save();
            }

            return $firstPrintInfo->id;
        });
    }

    public function updateFirstPrintInfo(UpdateFirstPrintInfoRequest $firstPrintInfoRequest){
        /** @var FirstPrintInfo $firstPrintInfo */
        $firstPrintInfo = $this->firstPrintInfoRepository->find($firstPrintInfoRequest->getId());
        Ensure::objectNotNull('first print info to update', $firstPrintInfo);
        $updatedFirstPrintInfo = $this->saveFirstPrintInfo($firstPrintInfoRequest, $firstPrintInfo);
        return $updatedFirstPrintInfo->id;
    }

    public function linkBook($id, LinkBookToFirstPrintInfoRequest $linkBookToFirstPrintInfoRequest){
        $firstPrintInfo = $this->firstPrintInfoRepository->find($id);
        Ensure::objectNotNull('first print info to link', $firstPrintInfo);
        /** @var Book $book */
        $book = $this->bookRepository->find($linkBookToFirstPrintInfoRequest->getBookId());
        Ensure::objectNotNull('book to link', $book);

        $book->first_print_info_id = $id;
        $book->save();
    }

    public function findOrCreate(FirstPrintInfoParameters $firstPrintInfoParameters)
    {
        $firstPrintInfo = new FirstPrintInfo();

        if (!StringUtils::isEmpty($firstPrintInfoParameters->getIsbn())) {
            $first = FirstPrintInfo::where('ISBN', '=', $firstPrintInfoParameters->getIsbn())->first();
            if($first != null){
                $firstPrintInfo = $first;
            }
        }

        $firstPrintInfo->title = $firstPrintInfoParameters->getTitle();
        $firstPrintInfo->subtitle = $firstPrintInfoParameters->getSubtitle();
        $firstPrintInfo->ISBN = $firstPrintInfoParameters->getIsbn();
        if (!StringUtils::isEmpty($firstPrintInfoParameters->getLanguage())) {
            $language = $this->languageService->findOrCreate($firstPrintInfoParameters->getLanguage());
            $firstPrintInfo->language()->associate($language);
        }
        if ($firstPrintInfoParameters->getPublicationDate() != null) {
            $firstPrintInfoParameters->getPublicationDate()->save();
            $firstPrintInfo->publication_date()->associate($firstPrintInfoParameters->getPublicationDate());
        }
        $country = null;

        if ($firstPrintInfoParameters->getCountry() != null && $firstPrintInfoParameters->getCountry() !== '') {
            $country = $this->countryService->findOrCreate($firstPrintInfoParameters->getCountry());
            $firstPrintInfo->country()->associate($country);
        }
        if ($firstPrintInfoParameters->getPublisher() != null) {
            $publisher = $this->publisherService->findOrCreate($firstPrintInfoParameters->getPublisher());
            $firstPrintInfo->publisher()->associate($publisher);
        }
        $firstPrintInfo->save();

        return $firstPrintInfo;
    }

    public function saveOrUpdate($title, $subtitle, $isbn, Date $publication_date = null, $publisherName, $countryId, $languageId)
    {
        $publication_date_id = null;
        $firstPrintInfo = null;
        if (!is_null($publication_date)) {
            $publication_date_id = $publication_date->id;
        }
        if (!is_null($isbn)) {
            $firstPrintInfo = FirstPrintInfo::where('ISBN', '=', $isbn)->first();
        }

        if (is_null($firstPrintInfo)) {
            $firstPrintInfo = new FirstPrintInfo();
        }

        if (!empty($publisherName)) {
            $publisher_id = App::make('PublisherService')->saveOrUpdate($publisherName, Country::find($countryId))->id;
        } else {
            $publisher_id = null;
        }

        $firstPrintInfo->title = $title;
        $firstPrintInfo->subtitle = $subtitle;
        $firstPrintInfo->publication_date_id = $publication_date_id;
        $firstPrintInfo->publisher_id = $publisher_id;
        $firstPrintInfo->ISBN = $isbn;
        $firstPrintInfo->country_id = $countryId;
        $firstPrintInfo->language_id = $languageId;

        $firstPrintInfo->save();
        return $firstPrintInfo;
    }

    /**
     * @param BaseFirstPrintInfoRequest $updateFirstPrint
     * @return Date
     */
    private function createPublicationDate(BaseFirstPrintInfoRequest $updateFirstPrint)
    {
        $date = new Date();
        $date->day = $updateFirstPrint->getPublicationDate()->getDay();
        $date->month = $updateFirstPrint->getPublicationDate()->getDay();
        $date->year = $updateFirstPrint->getPublicationDate()->getYear();
        $date->save();
        return $date;
    }

    /**
     * @param BaseFirstPrintInfoRequest $firstPrintInfoRequest
     * @param $firstPrintInfo
     * @throws ServiceException
     * @return FirstPrintInfo
     */
    private function saveFirstPrintInfo(BaseFirstPrintInfoRequest $firstPrintInfoRequest, FirstPrintInfo $firstPrintInfo)
    {
        if(!StringUtils::isEmpty($firstPrintInfoRequest->getPublisher())){
            $publisher = $this->publisherService->findOrCreate($firstPrintInfoRequest->getPublisher());
            $firstPrintInfo->publisher_id = $publisher->id;
        }else{
            $firstPrintInfo->publisher_id = null;
        }

        if(!StringUtils::isEmpty($firstPrintInfoRequest->getLanguage())){
            $language = $this->languageService->findOrCreate($firstPrintInfoRequest->getLanguage());
            $firstPrintInfo->language_id = $language->id;
        }else{
            $firstPrintInfo->language_id = null;
        }

        if(!StringUtils::isEmpty($firstPrintInfoRequest->getCountry())){
            $country = $this->countryService->findOrCreate($firstPrintInfoRequest->getCountry());
            $firstPrintInfo->country_id = $country->id;
        }else{
            $firstPrintInfo->country_id = null;
        }

        if($firstPrintInfoRequest->getPublicationDate() != null && !StringUtils::isEmpty($firstPrintInfoRequest->getPublicationDate()->getYear())){
            $date = $this->createPublicationDate($firstPrintInfoRequest);
            $firstPrintInfo->publication_date_id = $date->id;
        }else{
            $firstPrintInfo->publication_date_id = null;
        }

        $firstPrintInfo->title = $firstPrintInfoRequest->getTitle();
        $firstPrintInfo->subtitle = $firstPrintInfoRequest->getSubtitle();
        $firstPrintInfo->ISBN = $firstPrintInfoRequest->getIsbn();

        $firstPrintInfo->save();
        return $firstPrintInfo;
    }
}