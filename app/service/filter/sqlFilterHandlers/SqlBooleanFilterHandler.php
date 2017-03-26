<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Doctrine\DBAL\Query\QueryBuilder;

class SqlBooleanFilterHandler implements FilterHandler
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
        /** @var QueryBuilder $queryBuilder */
        return $queryBuilder->where($this->tableName, '=', $filter->getValue());
    }
}