<?php

class BookFilterHandler
{

    /** @var array  */
    private $filters;

    public function __construct()
    {
        $this->filters = array(
            "book-title" => new BookTitleFilterHandler(),
            "book-country" => new BookCountryFilterHandler(),
            "book-language" => new BookLanguageFilterHandler(),
            "book-genre" => new BookGenreFilterHandler(),
            "book-retail_price" => new BookRetailPriceFilterHandler(),
            "book-publisher" => new BookPublisherFilterHandler(),
            "personal-owned" => new BookOwnedFilterHandler(),
            "personal-read" => new BookReadFilterHandler(),
            "personal-rating" => new BookRatingFilterHandler(),
            "personal-readingyear" => new BookReadingYearFilterHandler(),
            "personal-readingmonth" => new BookReadingMonthFilterHandler(),
            "personal-buy_price" => new BookBuyPriceFilterHandler(),
            "buy-gift-from" => new BookGiftFromFilterHandler(),
        );
    }

    public function handle($filterId, $queryBuilder, $value, $operator){
        /** @var FilterHandler $handler */
        $handler = $this->filters[$filterId];
        return $handler->handleFilter($queryBuilder, $value, $operator);
    }

    public function getFilters()
    {
        return $this->filters;
    }
}