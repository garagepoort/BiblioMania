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
        return $queryBuilder
            ->leftJoin('country as book_country', 'book.publisher_country_id', '=', 'book_country.id')
            ->whereIn("book_country.name", $value);
    }

    public function getFilterId()
    {
        return "book-country";
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
        $result["Geen waarde"] = "";
        foreach($this->countryService->getCountries() as $country){
            if(!StringUtils::isEmpty($country->name)){
                $result[$country->name] = $country->name;
            }else{
                $result["Geen waarde"] = $country->name;
            }
        }
        return $result;
    }

    public function getSupportedOperators()
    {
        return array("in"=>FilterOperator::IN);
    }
}