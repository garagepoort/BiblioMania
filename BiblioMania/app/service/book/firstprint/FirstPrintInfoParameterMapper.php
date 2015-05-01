<?php

class FirstPrintInfoParameterMapper {

    /** @var  DateService */
    private $dateService;
    /** @var  LanguageService */
    private $languageService;


    function __construct()
    {
        $this->dateService = App::make('DateService');
        $this->languageService = App::make('LanguageService');
    }


    public function create(){
        $first_print_publication_date = $this->dateService->createDate(
            Input::get('first_print_publication_date_day'),
            Input::get('first_print_publication_date_month'),
            Input::get('first_print_publication_date_year'));

        $language = $this->languageService->find(Input::get('first_print_languageId'));
        $country = new Country();
        $country->name = Input::get('first_print_country');

        return new FirstPrintInfoParameters(
            Input::get("first_print_title"),
            Input::get("first_print_subtitle"),
            Input::get("first_print_isbn"),
            $first_print_publication_date,
            Input::get('first_print_publisher'),
            $language,
            $country
        );
    }
}