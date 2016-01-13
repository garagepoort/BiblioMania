<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

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

    public function handleFilter(Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){ return StringUtils::toLowerCase($item->value); }, (array) $filter->getValue());

        return FilterBuilder::terms('country', $options);
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