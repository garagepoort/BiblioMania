<?php

class BookFilter
{
    const RATING = "rating";
    const TITLE = "title";
    const SUBTITLE = "subtitle";
    const RETAIL_PRICE = "retail_price";

    public $columnName;
    public $viewName;

    public function __construct($columnName, $viewName)
    {
        $this->columnName = $columnName;
        $this->viewName = $viewName;
    }

    public static function getFilters()
    {
        return array(
            new BookFilter(BookFilter::RATING, 'waardering'),
            new BookFilter(BookFilter::TITLE, 'titel'),
            new BookFilter(BookFilter::SUBTITLE, 'ondertitel'),
            new BookFilter(BookFilter::RETAIL_PRICE, 'cover prijs')
        );
    }
}