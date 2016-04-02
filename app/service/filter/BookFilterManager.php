<?php

use Bendani\PhpCommon\FilterService\Model\FilterManager;
use Bendani\PhpCommon\Utils\Ensure;

class BookFilterManager extends FilterManager
{
    /** @var  FilterHistoryService */
    private $filterHistoryService;

    public function __construct()
    {
        $filters = array(new BookTitleFilter(),
            new BookCountryFilter(),
            new BookLanguageFilter(),
            new BookGenreFilter(),
            new BookRetailPriceFilter(),
            new BookPublisherFilter(),
            new BookOwnedFilter(),
            new BookReadFilter(),
            new BookRatingFilter(),
            new BookReadingDateFilter(),
            new BookBuyPriceFilter(),
            new BookBuyDateFilter(),
            new BookGiftFromFilter(),
            new BookAuthorFilter(),
            new BookIsPersonalFilter(),
            new BookTagFilter()
        );
        parent::__construct($filters);

        $this->filterHistoryService = App::make('FilterHistoryService');
    }

    public function getMostUsedFilters()
    {
        $filterHistories = $this->filterHistoryService->getMostUsedFilters();
        $result = array();
        /** @var FilterHistory $filterHistory */
        foreach ($filterHistories as $filterHistory) {
            $filter = $this->getFilter($filterHistory->filter_id);
            Ensure::objectNotNull('filter from most used', $filter, 'Filter in most used filters is not found in filter manager');
            array_push($result, $filter);
        }
        return $result;
    }

}