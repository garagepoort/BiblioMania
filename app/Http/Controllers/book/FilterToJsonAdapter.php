<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class FilterToJsonAdapter
{

    private $id;
    private $key;
    private $group;
    private $type;
    private $supportedOperators;
    private $options;

    /**
     * FilterToJsonAdapter constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter)
    {
        $this->id = $filter->getFilterId();
        $this->key = $filter->getField();
        $this->type = $filter->getType();
        $this->group = $filter->getGroup();
        $this->supportedOperators = $filter->getSupportedOperators();

        $this->options = method_exists($filter, "getOptions") ? $filter->getOptions() : null;
    }

    public function mapToJson(){
        $result = array(
            'id' => $this->id,
            'key' => $this->key,
            'group' => $this->group,
            'type' => $this->type,
        );

        if($this->supportedOperators !== null){
            $result['supportedOperators'] = $this->supportedOperators;
        }

        if($this->options !== null){
            $result['options'] = $this->options;
        }

        return $result;
    }


}