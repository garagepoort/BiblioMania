<?php

use Bendani\PhpCommon\FilterService\Model\OptionsFilter;

class BookLanguageFilter implements OptionsFilter
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

    public function getFilterId()
    {
        return FilterType::BOOK_LANGUAGE;
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

}