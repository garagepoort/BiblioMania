<?php

use Bendani\PhpCommon\Utils\Ensure;

class CreateChartConfigurationFromJsonAdapter implements CreateChartConfigurationRequest
{

    /**
     * @var string
     * @required
     */
    private $title;

    /** @var string */
    /** @required */
    private $xProperty;

    /** @required */
    private $conditions;

    function getTitle()
    {
        return $this->title;
    }

    function getXProperty()
    {
        return $this->xProperty;
    }

    function getConditions()
    {
        return $this->jsonToFilters();
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $xProperty
     */
    public function setXProperty($xProperty)
    {
        $this->xProperty = $xProperty;
    }

    /**
     * @param mixed $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
    }

    private function jsonToFilters()
    {
        $filtersInJson = $this->conditions;
        Ensure::objectIsArray('filters', $filtersInJson);

        $allFiltersFromJsonAdapter = new AllFiltersFromJsonAdapter($filtersInJson);

        $conditions = array();
        /** @var \Bendani\PhpCommon\FilterService\Model\Filter $filter */
        foreach($allFiltersFromJsonAdapter->getFilters() as $filter){
            $chartConditionFromJsonAdapter = new ChartConditionFromJsonAdapter();
            $chartConditionFromJsonAdapter->setOperator($filter->getOperator());
            $chartConditionFromJsonAdapter->setProperty($filter->getId());
            $chartConditionFromJsonAdapter->setValue($filter->getValue());
            array_push($conditions, $chartConditionFromJsonAdapter);
        }
        $allFilters = $allFiltersFromJsonAdapter->getFilters();

        return $allFilters;
    }


}