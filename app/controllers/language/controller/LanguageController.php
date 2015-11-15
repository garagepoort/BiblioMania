<?php

class LanguageController extends BaseController
{

    /** @var LanguageService $languageService */
    private $languageService;
    /** @var LanguageJsonMapper $languageJsonMapper */
    private $languageJsonMapper;

    function __construct()
    {
        $this->languageService = App::make('LanguageService');
        $this->languageJsonMapper = App::make('LanguageJsonMapper');
    }

    public function getLanguages(){
        return $this->languageJsonMapper->mapArrayToJson($this->languageService->getLanguages());
    }

}