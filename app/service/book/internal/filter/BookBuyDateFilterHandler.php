<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
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

    public function handleFilter(Filter $filter)
    {
        /** @var FilterDateRequest $filterDateRequest */
        $filterDateRequest = $filter->getValue();
        Ensure::objectIsInstanceOf('date', $filterDateRequest, 'Bendani\PhpCommon\FilterService\Model\FilterDateRequest');
        Ensure::objectIsInstanceOf('date from', $filterDateRequest->getFrom(), 'DateRequest');

        $dateFrom = $this->dateFormatter->dateRequestToFormattedDate($filterDateRequest->getFrom());

        if($filterDateRequest->getTo() !== null){
            Ensure::objectIsInstanceOf('date to', $filterDateRequest->getTo(), 'DateRequest');
            $dateTo = $this->dateFormatter->dateRequestToFormattedDate($filterDateRequest->getTo());
            return FilterBuilder::range('personalBookInfos.buyInfo.buy_date', $dateFrom, $dateTo);
        }
        return FilterBuilder::greaterThan('personalBookInfos.buyInfo.buy_date', $dateFrom);
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
}