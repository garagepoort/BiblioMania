<?php

class FirstPrintInfoService
{

    /** @var  PublisherService */
    private $publisherService;
    /** @var  CountryService */
    private $countryService;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
        $this->countryService = App::make('CountryService');
    }


    public function findOrCreate(FirstPrintInfoParameters $firstPrintInfoParameters){
        $firstPrintInfo = null;

        $country = $this->countryService->findOrCreate($firstPrintInfoParameters->getCountry());
        $publisher = $this->publisherService->findOrCreate($firstPrintInfoParameters->getPublisher(), $country);

        if (!is_null($firstPrintInfoParameters->getIsbn())) {
            $firstPrintInfo = FirstPrintInfo::where('ISBN', '=', $firstPrintInfoParameters->getIsbn())->first();
        }

        if(is_null($firstPrintInfo)){
            $firstPrintInfo = new FirstPrintInfo();
        }
        $firstPrintInfoParameters->getPublicationDate()->save();

        $firstPrintInfo->title = $firstPrintInfoParameters->getTitle();
        $firstPrintInfo->subtitle = $firstPrintInfoParameters->getSubtitle();
        $firstPrintInfo->publication_date_id = $firstPrintInfoParameters->getPublicationDate()->id;
        $firstPrintInfo->ISBN = $firstPrintInfoParameters->getIsbn();
        $firstPrintInfo->language_id = $firstPrintInfoParameters->getLanguageId();
        $firstPrintInfo->publisher_id = $publisher->id;
        $firstPrintInfo->country_id = $country->id;
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