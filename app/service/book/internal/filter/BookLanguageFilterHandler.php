<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
use Bendani\PhpCommon\FilterService\Model\FilterBuilder;
use Bendani\PhpCommon\FilterService\Model\FilterOperator;
use Bendani\PhpCommon\FilterService\Model\OptionsFilterHandler;
use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookLanguageFilterHandler implements OptionsFilterHandler
{
    /** @var  LanguageService $languageService */
    private $languageService;
    /**
     * BookCountryFilterHandler constructor.
     */
    public function __construct()
    {
        $this->languageService = App::make('LanguageService');
    }

    public function handleFilter(Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){ return StringUtils::toLowerCase($item->value); }, (array) $filter->getValue());

        return FilterBuilder::terms('language', $options);
    }

    public function getFilterId()
    {
        return "book-language";
    }

    public function getType()
    {
        return "multiselect";
    }

    public function getField()
    {
        return "Taal";
    }

    public function getOptions()
    {
        $options= array();
        foreach($this->languageService->getLanguages() as $language){
            array_push($options, array("key"=>$language->language, "value"=>$language->id));
        }
        return $options;
    }

    public function getSupportedOperators(){return null;}

    public function getGroup()
    {
        return "book";
    }

    public function joinQuery($queryBuilder)
    {
        return $queryBuilder;
    }
}