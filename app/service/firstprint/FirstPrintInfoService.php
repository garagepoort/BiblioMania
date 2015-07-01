<?php

class FirstPrintInfoService
{

    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;
    /** @var  LanguageService */
    private $languageService;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
        $this->languageService = App::make('LanguageService');
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
        if ($firstPrintInfoParameters->getLanguage() != null) {
            $firstPrintInfo->language()->associate($firstPrintInfoParameters->getLanguage());
        }
        if ($firstPrintInfoParameters->getPublicationDate() != null) {
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

}