<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;
use Bendani\PhpCommon\FilterService\Model\FilterValue;
use Doctrine\DBAL\Query\QueryBuilder;

class SqlDateRangeOrFilterHandler implements FilterHandler
{

    /** @var  SqlFullDateRangeFilterHandler */
    private $sqlFullDateRangeHandlerField1;
    /** @var  SqlFullDateRangeFilterHandler */
    private $sqlFullDateRangeHandlerField2;

    /**
     * SqlStringFilterHandler constructor.
     * @param $tableName
     */
    public function __construct($field1, $field2)
    {
        $this->sqlFullDateRangeHandlerField1 = new SqlFullDateRangeFilterHandler($field1);
        $this->sqlFullDateRangeHandlerField2 = new SqlFullDateRangeFilterHandler($field2);
    }


    public function handleFilter(FilterValue $filter, $queryBuilder = null)
    {
        $sqlFullDateRangeHandlerField1 = $this->sqlFullDateRangeHandlerField1;
        $sqlFullDateRangeHandlerField2 = $this->sqlFullDateRangeHandlerField2;

        /** @var QueryBuilder $queryBuilder */
        return $queryBuilder
            ->where(function ($q) use ($sqlFullDateRangeHandlerField1, $filter) {
                $sqlFullDateRangeHandlerField1->handleFilter($filter, $q);
            })
            ->orWhere(function ($q) use ($sqlFullDateRangeHandlerField2, $filter) {
                $sqlFullDateRangeHandlerField2->handleFilter($filter, $q);
            });
    }
}