<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;

class BookBuyDateFilterHandler implements FilterHandler
{

    /** @var  DateFormatter */
    private $dateFormatter;

    public function __construct()
    {
        $this->dateFormatter = App::make('DateFormatter');
    }

    public function handleFilter($queryBuilder, Filter $filter)
    {
        /** @var FilterDateRequest $filterDateRequest */
        $filterDateRequest = $filter->getValue();
        Ensure::objectIsInstanceOf('date', $filterDateRequest, 'Bendani\PhpCommon\FilterService\Model\FilterDateRequest');
        Ensure::objectIsInstanceOf('date from', $filterDateRequest->getFrom(), 'DateRequest');

        $dateFrom = $this->dateFormatter->dateRequestToDateTime($filterDateRequest->getFrom());

        $queryBuilder =  $queryBuilder->where("buy_info_date_join.buy_date", '>=', $dateFrom);

        if($filterDateRequest->getTo() !== null){
            Ensure::objectIsInstanceOf('date to', $filterDateRequest->getTo(), 'DateRequest');
            $dateTo = $this->dateFormatter->dateRequestToDateTime($filterDateRequest->getTo());
            $queryBuilder->where("buy_info_date_join.buy_date", '<=', $dateTo);
        }

        return $queryBuilder;
    }

    public function getFilterId()
    {
        return "personal-buy_date";
    }

    public function getType()
    {
        return "date";
    }

    public function getField()
    {
        return "Aankoop datum";
    }

    public function getSupportedOperators(){
        return null;
    }

    public function getGroup()
    {
        return "personal";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder->join("buy_info as buy_info_date_join", "buy_info_date_join.personal_book_info_id", "=", "personal_book_info.id");
    }
}