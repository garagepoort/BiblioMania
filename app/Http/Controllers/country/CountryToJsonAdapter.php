<?php

class CountryToJsonAdapter
{

    /** @var string */
    private $name;

    /**
     * CountryJsonMapper constructor.
     * @param string $name
     */
    public function __construct(Country $country)
    {
        $this->name = $country->name;
    }


    public function mapToJson(){
        return array('name'=>$this->name);
    }
}