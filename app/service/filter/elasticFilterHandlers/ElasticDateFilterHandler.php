<?php

use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;

class ElasticDateFilterHandler implements FilterHandler
{
    private $field;

    /** @var  DateFormatter */
    private $dateFormatter;

    public function __construct($field)
    {
        $this->dateFormatter = App::make('DateFormatter');
        $this->field = $field;
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
            return FilterBuilder::range($this->field, $dateFrom, $dateTo);
        }
        return FilterBuilder::greaterThan($this->field, $dateFrom);
    }
}