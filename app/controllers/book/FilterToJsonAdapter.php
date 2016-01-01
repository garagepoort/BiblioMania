<?php

use Bendani\PhpCommon\FilterService\Model\FilterHandler;

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
     * @param FilterHandler $filterHandler
     */
    public function __construct(FilterHandler $filterHandler)
    {
        $this->id = $filterHandler->getFilterId();
        $this->key = $filterHandler->getField();
        $this->type = $filterHandler->getType();
        $this->group = $filterHandler->getGroup();
        $this->supportedOperators = $filterHandler->getSupportedOperators();

        $this->options = method_exists($filterHandler, "getOptions") ? $filterHandler->getOptions() : null;
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