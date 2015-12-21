<?php

use Bendani\PhpCommon\FilterService\Model\Filter;
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

    public function handleFilter($queryBuilder, Filter $filter)
    {
        Ensure::objectNotNull('selected options', $filter->getValue());

        $options = array_map(function($item){
            return $item->value;
        }, (array) $filter->getValue());

        return $queryBuilder->leftJoin('language as book_language', 'book.language_id', '=', 'book_language.id')
            ->whereIn("book_language.language", $options);
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
        $noValueOption = array("key" => "Geen waarde", "value" => "");
        array_push($options, $noValueOption);
        foreach($this->languageService->getLanguages() as $language){
            if(!StringUtils::isEmpty($language->language)){
                array_push($options, array("key"=>$language->language, "value"=>$language->language));
            }else{
                $noValueOption["value"] = $language->language;
            }
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