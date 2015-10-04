<?php

class BookFilterHandler
{

    /** @var array  */
    private $filters;

    public function __construct()
    {
        $this->filters = array(
            "book.title" => new BookTitleFilterHandler(),
            "book.country" => new BookCountryFilterHandler(),
            "book.language" => new BookLanguageFilterHandler(),
            "book.genre" => new BookGenreFilterHandler(),
            "personal.owned" => new BookOwnedFilterHandler(),
            "personal.read" => new BookReadFilterHandler(),
            "personal.rating" => new BookRatingFilterHandler(),
            "personal.readingyear" => new BookReadingYearFilterHandler(),
            "personal.readingmonth" => new BookReadingMonthFilterHandler(),
        );
    }

    public function handle($filterId, $queryBuilder, $value){
        /** @var FilterHandler $handler */
        $handler = $this->filters[$filterId];
        return $handler->handleFilter($queryBuilder, $value);
    }

    public function getFilters()
    {
        return $this->filters;
    }
}