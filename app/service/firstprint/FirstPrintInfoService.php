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
    /** @var DateService $dateService */
    private $dateService;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->languageService = App::make('LanguageService');
        $this->firstPrintInfoRepository = App::make('FirstPrintInfoRepository');
        $this->bookRepository = App::make('BookRepository');
        $this->dateService = App::make('DateService');
    }

    /**
     * @param $userId
     * @param CreateFirstPrintInfoRequest $firstPrintInfoRequest
     * @return FirstPrintInfo
     */
    public function createFirstPrintInfo($userId, CreateFirstPrintInfoRequest $firstPrintInfoRequest){
        return DB::transaction(function() use ($firstPrintInfoRequest, $userId){
            $firstPrint = new FirstPrintInfo();
            $firstPrintInfo = $this->saveFirstPrintInfo($userId, $firstPrintInfoRequest, $firstPrint);

            if($firstPrintInfoRequest->getBookIdToLink() !== null){
                $this->linkFirstPrintInfoToBook($firstPrintInfo->id, $firstPrintInfoRequest->getBookIdToLink());
            }

            return $firstPrintInfo;
        });
    }

    /**
     * @param $userId
     * @param UpdateFirstPrintInfoRequest $firstPrintInfoRequest
     * @return FirstPrintInfo
     * @throws ServiceException
     */
    public function updateFirstPrintInfo($userId, UpdateFirstPrintInfoRequest $firstPrintInfoRequest){
        /** @var FirstPrintInfo $firstPrintInfo */
        $firstPrintInfo = $this->firstPrintInfoRepository->find($firstPrintInfoRequest->getId());
        Ensure::objectNotNull('first print info to update', $firstPrintInfo);
        $updatedFirstPrintInfo = $this->saveFirstPrintInfo($userId, $firstPrintInfoRequest, $firstPrintInfo);
        return $updatedFirstPrintInfo;
    }

    public function linkBook($id, LinkBookToFirstPrintInfoRequest $linkBookToFirstPrintInfoRequest){
        $firstPrintInfo = $this->firstPrintInfoRepository->find($id);
        Ensure::objectNotNull('first print info to link', $firstPrintInfo);
        $this->linkFirstPrintInfoToBook($id, $linkBookToFirstPrintInfoRequest->getBookId());
    }

    /**
     * @param BaseFirstPrintInfoRequest $firstPrintInfoRequest
     * @param $firstPrintInfo
     * @throws ServiceException
     * @return FirstPrintInfo
     */
    private function saveFirstPrintInfo($userId, BaseFirstPrintInfoRequest $firstPrintInfoRequest, FirstPrintInfo $firstPrintInfo)
    {
        if(!StringUtils::isEmpty($firstPrintInfoRequest->getPublisher())){
            $publisher = $this->publisherService->findOrCreate($userId, $firstPrintInfoRequest->getPublisher());
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
            $date = $this->dateService->create($firstPrintInfoRequest->getPublicationDate());
            $firstPrintInfo->publication_date_id = $date->id;
        }else{
            $firstPrintInfo->publication_date_id = null;
        }

        $firstPrintInfo->title = $firstPrintInfoRequest->getTitle();
        $firstPrintInfo->subtitle = $firstPrintInfoRequest->getSubtitle();
        $firstPrintInfo->ISBN = $firstPrintInfoRequest->getIsbn();

        $this->firstPrintInfoRepository->save($firstPrintInfo);
        return $firstPrintInfo;
    }

    /**
     * @param $id
     * @param LinkBookToFirstPrintInfoRequest $linkBookToFirstPrintInfoRequest
     * @throws ServiceException
     */
    private function linkFirstPrintInfoToBook($id, $bookId)
    {
        /** @var Book $book */
        $book = $this->bookRepository->find($bookId);
        Ensure::objectNotNull('book to link', $book);
        $book->first_print_info_id = $id;
        $this->bookRepository->save($book);
    }
}