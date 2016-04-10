<?php

use Bendani\PhpCommon\FilterService\Model\FilterDateRequest;
use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Bendani\PhpCommon\Utils\StringUtils;

class SqlFullDateRangeFilterHandler implements FilterHandler
{
    private $field;
    /** @var  DateFormatter */
    private $dateFormatter;

    /**
     * SqlDateRangeFilterHandler constructor.
     * @param $field
     */
    public function __construct($field)
    {
        $this->field = $field;
        $this->dateFormatter = App::make('DateFormatter');
    }


    public function handleFilter(\Bendani\PhpCommon\FilterService\Model\FilterValue $filter, $queryBuilder = null)
    {
        /** @var FilterDateRequest $filterDateRequest */
        $filterDateRequest = $filter->getValue();
        Ensure::objectIsInstanceOf('date', $filterDateRequest, 'Bendani\PhpCommon\FilterService\Model\FilterDateRequest');
        Ensure::objectIsInstanceOf('date from', $filterDateRequest->getFrom(), 'DateRequest');

        $dateFrom = $this->dateFormatter->dateRequestToFormattedDate($filterDateRequest->getFrom());

        if($filterDateRequest->getTo() !== null){
            Ensure::objectIsInstanceOf('date to', $filterDateRequest->getTo(), 'DateRequest');
            $dateTo = $this->dateFormatter->dateRequestToFormattedDate($filterDateRequest->getTo());
            return $queryBuilder
                ->whereNotNull($this->field)
                ->where($this->field, '>=', $dateFrom)
                ->where($this->field, '<=', $dateTo);
        }
        return $queryBuilder->where($this->field, '>', $dateFrom);
    }
}