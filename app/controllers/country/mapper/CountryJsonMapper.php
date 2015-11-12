<?php

class CountryJsonMapper
{

    public function mapToJson(Country $country){
        /** @var CountryData $countryData */
        $countryData = new CountryData();
        $countryData->setName($country->name);
        return $countryData->toJson();
    }

    public function mapArrayToJson($countries){
        $result = array();
        foreach($countries as $country){
            array_push($result, $this->mapToJson($country));
        }
        return $result;
    }
}