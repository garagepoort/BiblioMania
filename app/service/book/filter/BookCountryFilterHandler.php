<?php

class BookCountryFilterHandler implements OptionsFilterHandler
{
    /** @var  CountryService $countryService */
    private $countryService;
    /**
     * BookCountryFilterHandler constructor.
     */
    public function __construct()
    {
        $this->countryService = App::make('CountryService');
    }

    public function handleFilter($queryBuilder, $value, $operator)
    {
        return $queryBuilder->whereIn("book_country.name", $value);
    }

    public function getFilterId()
    {
        return "book.country";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Land";
    }

    public function getOptions()
    {
        $result= array();
        foreach($this->countryService->getCountries() as $country){
            $result[$country->name] = $country->name;
        }
        return $result;
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
    }
}