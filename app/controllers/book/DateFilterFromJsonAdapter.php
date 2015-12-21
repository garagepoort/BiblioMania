<?php

use Bendani\PhpCommon\FilterService\Model\Filter;

class DateFilterFromJsonAdapter implements Filter
{
    /** @var  string */
    /** @required */
    private $id;

    /** @var  FilterDateFromJsonAdapter */
    /** @required */
    private $value;

    /** @var  string */
    private $operator;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return FilterDateFromJsonAdapter
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param FilterDateFromJsonAdapter $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }



    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;
    }



}