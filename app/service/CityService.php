<?php

class CityService
{

    /** @var CityRepository $cityRepository */
    private $cityRepository;

    /**
     * CityService constructor.
     */
    public function __construct()
    {
        $this->cityRepository = App::make('CityRepository');
    }


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

    public function getCities(){
        return $this->cityRepository->all();
    }
}