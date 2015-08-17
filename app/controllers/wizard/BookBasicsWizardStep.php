<?php

class BookBasicsWizardStep extends  WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  LanguageService */
    private $languageService;
    /** @var  CurrencyService */
    private $currencyService;
    /** @var  CountryService */
    private $countryService;
    /** @var  BookInfoParameterMapper */
    private $bookInfoParameterMapper;
    /** @var  BookFormValidator */
    private $bookFormValidator;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->languageService = App::make('LanguageService');
        $this->currencyService = App::make('CurrencyService');
        $this->countryService = App::make('CountryService');
        $this->bookInfoParameterMapper = App::make('BookInfoParameterMapper');
        $this->bookFormValidator = App::make('BookFormValidator');
    }

    public function executeStep($id = null)
    {
        $validator = $this->bookFormValidator->createValidatorForBasics();

        if ($validator->fails()) {
            $this->hasErrors = true;
            return $validator;
        } else {
            $this->hasErrors = false;
            $bookInfoParameters = $this->bookInfoParameterMapper->createForBasics();
            $book = $this->bookService->saveBasics($bookInfoParameters);
            return $book;
        }
    }

    public function goToStep($id = null)
    {
        $genres = Genre::where('parent_id', '=', null)->get();
        if ($id == null) {
            $withArray = BookFormFiller::createArrayForCreate();
        } else {
            $withArray = BookFormFiller::fillBasicInfo($id);
        }

        $withArray['title'] = 'Boek basis';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        $withArray['languages'] = $this->languageService->getLanguagesMap();
        $withArray['currencies'] = $this->currencyService->getCurrencies();
        $withArray['genres'] = $genres;
        $withArray['countries_json'] = json_encode($this->countryService->getCountries());
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        $withArray['publishers_json'] = json_encode(Publisher::all());
        $withArray['tags_json'] = json_encode(Tag::all());
        $withArray['series_json'] = json_encode(Serie::all());
        $withArray['publisher_series_json'] = json_encode(PublisherSerie::all());
        return View::make($this->bookFolder . 'bookBasics')->with($withArray);
    }
}