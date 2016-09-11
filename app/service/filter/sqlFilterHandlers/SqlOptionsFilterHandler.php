<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Bendani\PhpCommon\Utils\Ensure;
use Doctrine\DBAL\Query\QueryBuilder;

class SqlOptionsFilterHandler implements FilterHandler
{

    private $tableName;

    /**
     * SqlStringFilterHandler constructor.
     * @param $tableName
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }


    public function handleFilter(FilterValue $filter, $queryBuilder = null)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        /** @var QueryBuilder $queryBuilder */
        return $queryBuilder->whereIn($this->tableName, $options);
    }
}