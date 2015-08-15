<?php

class FirstPrintWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  FirstPrintInfoParameterMapper */
    private $firstPrintInfoParameterMapper;
    /** @var  BookCreationService */
    private $bookCreationService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  CountryService */
    private $countryService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->firstPrintInfoParameterMapper = App::make('FirstPrintInfoParameterMapper');
        $this->bookCreationService = App::make('BookCreationService');
        $this->languageService = App::make('LanguageService');
        $this->countryService = App::make('CountryService');
    }

    public function executeStep($id = null)
    {
        $firstPrintParameters = $this->firstPrintInfoParameterMapper->create();
        return $this->bookCreationService->saveFirstPrintForBook($id, $firstPrintParameters);
    }

    public function goToStep($id = null)
    {
        $withArray = BookFormFiller::fillForFirstPrint($id);
        $withArray['title'] = 'Eerste druk';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps();
        $withArray['languages'] = $this->languageService->getLanguagesMap();
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['publishers_json'] = json_encode(Publisher::all());
        return View::make($this->bookFolder . 'firstprint')->with($withArray);
    }
}