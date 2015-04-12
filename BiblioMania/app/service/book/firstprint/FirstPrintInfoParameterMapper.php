<?php

class FirstPrintInfoParameterMapper {

    /** @var  DateService */
    private $dateService;

    function __construct()
    {
        $this->dateService = App::make('DateService');
    }


    public function create(){
        $first_print_publication_date = $this->dateService->createDate(
            Input::get('first_print_publication_date_day'),
            Input::get('first_print_publication_date_month'),
            Input::get('first_print_publication_date_year'));

        return new FirstPrintInfoParameters(
            Input::get("first_print_title"),
            Input::get("first_print_subtitle"),
            Input::get("first_print_isbn"),
            $first_print_publication_date,
            Input::get('first_print_publisher'),
            Input::get('first_print_languageId'),
            Input::get('first_print_country')
        );
    }
}