<?php

use Bendani\PhpCommon\FilterService\Model\FilterManager;

class BookFilterManager extends FilterManager
{
    /** @var  FilterHistoryService */
    private $filterHistoryService;

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
            new BookIsPersonalFilterHandler(),
            new BookTagFilterHandler()
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