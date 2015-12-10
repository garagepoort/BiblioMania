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
    /** @var CountryService $countryService */
    private $countryService;
    /** @var CountryJsonMapper $countryJsonMapper */
    private $countryJsonMapper;

    function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->countryJsonMapper = App::make('CountryJsonMapper');
    }


    public function getCountries(){
        return $this->countryJsonMapper->mapArrayToJson($this->countryService->getCountries());
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