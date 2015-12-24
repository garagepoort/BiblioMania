<?php

use Bendani\PhpCommon\FilterService\Model\FilterManager;

class BookFilterManager extends FilterManager
{

    public function __construct()
    {
        $filters = array(new BookTitleFilterHandler(),
            new BookCountryFilterHandler(),
            new BookLanguageFilterHandler(),
            new BookGenreFilterHandler(),
            new BookRetailPriceFilterHandler(),
            new BookPublisherFilterHandler(),
            new BookOwnedFilterHandler(),
            new BookReadFilterHandler(),
            new BookRatingFilterHandler(),
            new BookReadingYearFilterHandler(),
            new BookReadingMonthFilterHandler(),
            new BookBuyPriceFilterHandler(),
            new BookBuyDateFilterHandler(),
            new BookGiftFromFilterHandler(),
            new BookAuthorFilterHandler(),
            new BookIsPersonalFilterHandler()
        );
        parent::__construct($filters);
    }

}