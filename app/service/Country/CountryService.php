<?php

class CountryService
{

    function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getCountries()
    {
        return $this->countryRepository->all();
    }

    public function findOrCreate($name)
    {
        $country = $this->countryRepository->getCountry($name);
        if (is_null($country)) {
            $country = new Country(array('name' => $name));
        }
        $this->countryRepository->save($country);
        return $country;
    }

    public function find($name)
    {
       return $this->countryRepository->getCountry($name);
    }

    public function editCountryName($id, $name) {
        $country = $this->countryRepository->find($id);

        if($country == null) {
            throw new ServiceException("country.error.notfound");
        }
        if($name == '' || $name == null){
            throw new ServiceException("country.error.empty.name");
        }

        $country->name = $name;
        $this->countryRepository->save($country);
    }

    public function deleteCountry(){
        $id = Input::get('countryId');

        $country = $this->countryRepository->findFull($id);

        if($country == null) {
            throw new ServiceException("country.error.notfound");
        }

        if(count($country->books) == 0
            && count($country->authors) == 0
            && count($country->cities) == 0
            && count($country->publishers) == 0
            && count($country->first_print_infos) == 0){

            $this->countryRepository->delete($country);
        }else{
            throw new ServiceException("country.error.notDeletable " . $country->name);
        }
    }

    public function mergeCountries($countryId_1, $countryId_2){
        $country1 = $this->countryRepository->findFull($countryId_1);
        $country2 = $this->countryRepository->findFull($countryId_2);

        foreach($country2->books as $book){
            $book->country()->associate($country1);
            $book->save();
        }

        foreach($country2->cities as $city){
            $city->country()->associate($country1);
            $city->save();
        }

        foreach($country2->first_print_infos as $firstPrint){
            $firstPrint->country()->associate($country1);
            $firstPrint->save();
        }

        foreach($country2->authors as $author){
            $author->country()->associate($country1);
            $author->save();
        }

        foreach($country2->publishers as $publisher){
            $country1->publishers()->sync([$publisher->id], false);
            $country1->save();
        }

        $country2->publishers()->sync([]);
        $country2->save();
        $country2->delete();
    }

}