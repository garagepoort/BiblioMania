<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */
class CountryController extends BaseController
{

    private $countryFolder = "country/";
    private $countryService;

    function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }


    public function getCountryList()
    {
        $countries = Country::with('books', 'authors')->orderBy('name', 'asc')->get();
        return View::make($this->countryFolder . 'countryList')->with(array(
            'title' => 'Editeer landen',
            'countries' => $countries
        ));
    }

    public function editCountry()
    {
        $id = Input::get('pk');
        $name = Input::get('value');

        $this->countryService->editCountryName($id, $name);
    }

    public function deleteCountry()
    {
        $this->countryService->deleteCountry(Input::get('countryId'));
    }

    public function mergeCountries()
    {
        $this->countryService->mergeCountries(Input::get('country1_id'), Input::get('country2_id'));
    }
}