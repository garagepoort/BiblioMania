<?php

class CityToJsonAdapter
{

    /** @var string */
    private $name;

    /**
     * CountryJsonMapper constructor.
     * @param string $name
     */
    public function __construct(City $city)
    {
        $this->name = $city->name;
    }


    public function mapToJson(){
        return array('name'=>$this->name);
    }
}