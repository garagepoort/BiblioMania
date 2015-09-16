<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/05/15
 * Time: 11:25
 */

class BookFilterValues {

    const N_A = 'N/A';
    const YES = 'YES';
    const NO = 'NO';
    private $query;
    private $operator;
    private $type;
    private $read = self::N_A;
    private $owns = self::N_A;
    private $year = self::N_A;

    function __construct($query, $operator, $type, $read = self::N_A, $owns = self::N_A, $year = self::N_A)
    {
        $this->query = $query;
        $this->operator = $operator;
        $this->type = $type;
        $this->read = $read;
        $this->owns = $owns;
        $this->year = $year;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getOperator()
    {
        return $this->operator;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getRead()
    {
        return $this->read;
    }

    public function getOwns()
    {
        return $this->owns;
    }

    public function getYear()
    {
        return $this->year;
    }



}