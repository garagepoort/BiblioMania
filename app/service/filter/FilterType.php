<?php

use Bendani\PhpCommon\Utils\Model\BasicEnum;

class FilterType extends BasicEnum
{
    const BOOK_TITLE = "book-title";
    const BOOK_TAG = "book-tag";
    const BOOK_RETAIL_PRICE = "book-retail_price";
    const BOOK_READING_DATE = "personal-readingdate";
    const BOOK_READ = "personal-read";
    const BOOK_RATING = "personal-rating";
    const BOOK_PUBLISHER = "book-publisher";
    const BOOK_OWNED = "personal-owned";
    const BOOK_LANGUAGE = "book-language";
    const BOOK_IS_PERSONAL = "isPersonal";
    const BOOK_GENRE = "book-genre";
    const BOOK_COUNTRY = "book-country";
    const BOOK_BUY_PRICE = "personal-buy_price";
    const BOOK_BUY_DATE = "personal-buy_date";
    const BOOK_BUY_COUNTRY = "personal-buy_country";
    const BOOK_RETRIEVE_DATE = "personal-retrieve_date";
    const BOOK_AUTHOR = "book-author";
    const BOOK_BUY_GIFT_FROM = "buy-gift-from";
}