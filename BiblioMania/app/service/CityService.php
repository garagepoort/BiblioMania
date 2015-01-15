<?php

class CityService
{

    public function save($cityName, $country_id)
    {

        $city = City::where('country_id', '=', $country_id)->where('name', '=', $cityName)->first();

        if (is_null($city)) {
            $city = new City();
            $city->name = $cityName;
            $city->country_id = $country_id;
            $city->save();
        }
        return $city;
    }
}