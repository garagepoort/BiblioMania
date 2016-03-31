<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;

class BookBuyDateFilterHandler implements FilterHandler
{

    /** @var  DateFormatter */
    private $dateFormatter;

    public function __construct()
    {
        $this->dateFormatter = App::make('DateFormatter');
    }

    public function handleFilter(FilterValue $filter, $object = null)
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
}