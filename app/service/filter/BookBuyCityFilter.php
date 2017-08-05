<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;
use Bendani\PhpCommon\Utils\StringUtils;

class BookBuyCityFilter implements OptionsFilter
{
    /** @var  CityService $cityService */
    private $cityService;
    /**
     * BookCountryFilterHandler constructor.
     */
    public function __construct()
    {
        $this->cityService = App::make('CityService');
    }

    public function getFilterId()
    {
        return FilterType::BOOK_BUY_CITY;
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Stad aankoop";
    }

    public function getOptions()
    {
        $options= array();
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($this->cityService->getCities() as $city){
            if(!StringUtils::isEmpty($city->name)){
                array_push($options, array("key"=>$city->name, "value"=>$city->id));
            }else{
                $noValueOption["value"] = $city->id;
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
        return "personal";
    }
}