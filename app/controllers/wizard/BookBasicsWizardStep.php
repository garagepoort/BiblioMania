<?php

use Bendani\PhpCommon\WizardService\Model\WizardStep;

class BookBasicsWizardStep extends WizardStep
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
    /** @var GenreService */
    private $genreService;
    /** @var  BookInfoParameterMapper */
    private $bookInfoParameterMapper;
    /** @var  BookFormValidator */
    private $bookFormValidator;
    /** @var  BookBasicsJsonMapper */
    private $bookBasicsJsonMapper;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->languageService = App::make('LanguageService');
        $this->currencyService = App::make('CurrencyService');
        $this->countryService = App::make('CountryService');
        $this->genreService = App::make('GenreService');
        $this->bookInfoParameterMapper = App::make('BookInfoParameterMapper');
        $this->bookFormValidator = App::make('BookFormValidator');
        $this->bookBasicsJsonMapper = App::make('BookBasicsJsonMapper');
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

    public function getModel($id = null)
    {
        $bookBasics = new BookBasics();
        $bookBasics = $bookBasics->toJson();
        if($id != null){
            $fullBook = $this->bookService->getFullBook($id);
            if($fullBook == null){
                return ResponseCreator::createExceptionResponse(new ServiceException("Book with id not found"));
            }
            $bookBasics = $this->bookBasicsJsonMapper->mapToJson($fullBook);
        }
        return $bookBasics;
    }

    public function getTitle()
    {
        return "Basis";
    }

    public function onExitGoTo($result)
    {
        return Redirect::to('getBooks?scroll_id=' . $result->id);
    }
}