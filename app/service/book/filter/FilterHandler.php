<?php

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 01/10/15
 * Time: 21:31
 */
interface FilterHandler
{

    public function handleFilter($queryBuilder, $value);

    public function getFilterId();

    public function getType();

    public function getField();
}