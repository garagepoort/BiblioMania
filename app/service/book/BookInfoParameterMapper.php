<?php

class BookInfoParameterMapper {

    /** @var DateService */
    private $dateService;
    /** @var LanguageService */
    private $languageService;

    function __construct()
    {
        $this->dateService = App::make('DateService');
        $this->languageService = App::make('LanguageService');
    }


    public function create(){
        if (Input::get('buyOrGift') == 'BUY') {
            $book_info_retail_price = Input::get('buy_book_info_retail_price');
        } else {
            $book_info_retail_price = Input::get('gift_book_info_retail_price');
        }

        $publicationDate = $this->dateService->createDate(Input::get('book_publication_date_day'),
            Input::get('book_publication_date_month'),
            Input::get('book_publication_date_year'));

        $language = $this->languageService->find(Input::get('book_languageId'));

        return new BookInfoParameters(
            Input::get("book_id"),
            Input::get("book_title"),
            Input::get("book_subtitle"),
            Input::get("book_isbn"),
            Input::get("book_genre"),
            $publicationDate,
            Input::get('book_publisher'),
            Input::get('book_country'),
            $language,
            $book_info_retail_price
        );
    }
}