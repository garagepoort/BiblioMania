<?php

class CountryService {

    public function getCountries(){
        return Country::all();
    }

}