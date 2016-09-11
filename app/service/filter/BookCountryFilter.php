<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookCountryFilter implements OptionsFilter
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

    public function getFilterId()
    {
        return FilterType::BOOK_COUNTRY;
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
        $options= array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($this->countryService->getCountries() as $country){
            if(!StringUtils::isEmpty($country->name)){
                array_push($options, array("key"=>$country->name, "value"=>$country->id));
            }else{
                $noValueOption["value"] = $country->id;
            }
        }
        return $options;
    }

    public function getSupportedOperators()
    {
        return null;
    }

    public function getGroup()
    {
        return "book";
    }
}