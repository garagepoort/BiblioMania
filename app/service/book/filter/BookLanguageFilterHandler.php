<?php

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

    public function handleFilter($queryBuilder, $value)
    {
        return $queryBuilder->where("book_language.language", "=", $value);
    }

    public function getFilterId()
    {
        return "book.language";
    }

    public function getType()
    {
        return "options";
    }

    public function getField()
    {
        return "Taal";
    }

    public function getOptions()
    {
        $result= array();
        foreach($this->languageService->getLanguages() as $language){
            $result[$language->language] = $language->language;
        }
        return $result;
    }
}