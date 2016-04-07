<?php

use Bendani\PhpCommon\FilterService\Model\FilterManager;
use Bendani\PhpCommon\Utils\Ensure;

class BookFilterManager extends FilterManager
{
    private $bookTitleFilter;
    private $bookCountryFilter;
    private $bookLanguageFilter;
    private $bookGenreFilter;
    private $bookRetailPriceFilter;
    private $bookPublisherFilter;
    private $bookOwnedFilter;
    private $bookReadFilter;
    private $bookRatingFilter;
    private $bookReadingDateFilter;
    private $bookBuyPriceFilter;
    private $bookBuyDateFilter;
    private $bookRetrieveDateFilter;
    private $bookGiftFromFilter;
    private $bookAuthorFilter;
    private $bookIsPersonalFilter;
    private $bookTagFilter;
    private $filters;
    private $chartFilters;

    /** @var  FilterHistoryService */
    private $filterHistoryService;

    public function __construct()
    {
        $this->bookTitleFilter = new BookTitleFilter();
        $this->bookCountryFilter = new BookCountryFilter();
        $this->bookLanguageFilter = new BookLanguageFilter();
        $this->bookGenreFilter = new BookGenreFilter();
        $this->bookRetailPriceFilter = new BookRetailPriceFilter();
        $this->bookPublisherFilter = new BookPublisherFilter();
        $this->bookOwnedFilter = new BookOwnedFilter();
        $this->bookReadFilter = new BookReadFilter();
        $this->bookRatingFilter = new BookRatingFilter();
        $this->bookReadingDateFilter = new BookReadingDateFilter();
        $this->bookBuyPriceFilter = new BookBuyPriceFilter();
        $this->bookBuyDateFilter = new BookBuyDateFilter();
        $this->bookRetrieveDateFilter = new BookRetrieveDateFilter();
        $this->bookGiftFromFilter = new BookGiftFromFilter();
        $this->bookAuthorFilter = new BookAuthorFilter();
        $this->bookIsPersonalFilter = new BookIsPersonalFilter();
        $this->bookTagFilter = new BookTagFilter();

        $this->filters = array($this->bookTitleFilter,
            $this->bookCountryFilter,
            $this->bookLanguageFilter,
            $this->bookGenreFilter,
            $this->bookRetailPriceFilter,
            $this->bookPublisherFilter,
            $this->bookOwnedFilter,
            $this->bookReadFilter,
            $this->bookRatingFilter,
            $this->bookReadingDateFilter,
            $this->bookBuyPriceFilter,
            $this->bookBuyDateFilter,
            $this->bookRetrieveDateFilter,
            $this->bookGiftFromFilter,
            $this->bookAuthorFilter,
            $this->bookIsPersonalFilter,
            $this->bookTagFilter
        );

        $this->chartFilters = array(
            $this->bookCountryFilter,
            $this->bookLanguageFilter,
            $this->bookGenreFilter,
            $this->bookRetailPriceFilter,
            $this->bookPublisherFilter,
            $this->bookOwnedFilter,
            $this->bookReadFilter,
            $this->bookRatingFilter,
            $this->bookReadingDateFilter,
            $this->bookBuyPriceFilter,
            $this->bookBuyDateFilter,
            $this->bookRetrieveDateFilter,
            $this->bookGiftFromFilter,
            $this->bookAuthorFilter,
            $this->bookTagFilter
        );

        parent::__construct($this->filters);

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

    public function getChartFilters(){
        return $this->chartFilters;
    }
}