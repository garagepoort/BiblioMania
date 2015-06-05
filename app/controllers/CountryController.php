<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */

class CountryController extends BaseController{

    private $countryFolder = "country/";
    private $countryService;

    function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }


    public function getCountryList(){
        $countries = Country::with('books', 'authors', 'publishers')->orderBy('name', 'asc')->get();
        return View::make($this->countryFolder . 'countryList')->with(array(
            'title' => 'Editeer landen',
            'countries' => $countries
        ));
    }

    public function editCountry(){
        $id = Input::get('pk');
        $name = Input::get('value');

        try {
            $this->countryService->editCountryName($id, $name);
        }catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function deleteCountry(){
        try {
            $this->countryService->deleteCountry(Input::get('countryId'));
        }catch (Exception $e){
            return $this->handleException($e);
        }
    }

    public function mergeCountries(){
        try{
            $this->countryService->mergeCountries(Input::get('country1_id'), Input::get('country2_id'));
        }catch (ServiceException $e){
            return $this->handleException($e);
        }
    }

    private function handleException($exception){
        return Response::json(array(
            'code'      =>  412,
            'message'   =>  $exception->getMessage()
        ), 412);
    }
}