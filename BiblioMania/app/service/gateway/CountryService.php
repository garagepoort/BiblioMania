<?php

class CountryService
{

    public function getCountries()
    {
        return Country::all();
    }

    public function findOrSave($name)
    {
        $country = Country::where('name', '=', $name)->first();
        if (is_null($country)) {
            $country = new Country(array('name' => $name));
            $country->save();
        }

        return $country;
    }

}