<?php

class BookExtrasWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  CurrencyService */
    private $currencyService;
    /** @var  ExtraBookInfoParameterMapper */
    private $extraBookInfoParameterMapper;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->currencyService = App::make('CurrencyService');
        $this->extraBookInfoParameterMapper = App::make('ExtraBookInfoParameterMapper');
    }

    public function executeStep($id = null)
    {
        $this->hasErrors = false;
        $bookExtras = $this->extraBookInfoParameterMapper->createForWizard();
        return $this->bookService->saveExtras($id, $bookExtras);
    }

    public function goToStep($id = null)
    {
        $withArray = BookFormFiller::fillForBookExtras($id);
        $withArray['title'] = 'Boek extras';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps();
        $withArray['tags_json'] = json_encode(Tag::all());
        $withArray['series_json'] = json_encode(Serie::all());
        $withArray['states'] = $this->bookService->getBookStates();;
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['publisher_series_json'] = json_encode(PublisherSerie::all());
        return View::make($this->bookFolder . 'bookExtra')->with($withArray);
    }
}