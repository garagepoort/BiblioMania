<?php

class CountryData
{

    /** @var string */
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function toJson(){
        return array(
            "name"=>$this->name
        );
    }
}