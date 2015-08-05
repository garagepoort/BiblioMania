<?php

class BookInfoParameterMapper {
    const TAG_DELIMITER = ";";

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
            $book_info_retail_price_currency = Input::get('buy_book_info_retail_price_currency');
        } else {
            $book_info_retail_price = Input::get('gift_book_info_retail_price');
            $book_info_retail_price_currency = Input::get('gift_book_info_retail_price_currency');
        }

        $publicationDate = $this->dateService->createDate(Input::get('book_publication_date_day'),
            Input::get('book_publication_date_month'),
            Input::get('book_publication_date_year'));

        $tags = StringUtils::split(Input::get('book_tags'), self::TAG_DELIMITER);

        return new BookInfoParameters(
            Input::get("book_id"),
            Input::get("book_title"),
            Input::get("book_subtitle"),
            Input::get("book_isbn"),
            Input::get("book_genre"),
            $publicationDate,
            Input::get('book_publisher'),
            Input::get('book_country'),
            Input::get('book_language'),
            $book_info_retail_price,
            $book_info_retail_price_currency,
            $tags
        );
    }
}