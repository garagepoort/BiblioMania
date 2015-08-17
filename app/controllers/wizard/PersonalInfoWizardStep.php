<?php

class PersonalInfoWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  PersonalBookInfoParameterMapper */
    private $personalBookInfoParameterMapper;
    /** @var  BookCreationService */
    private $bookCreationService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->personalBookInfoParameterMapper = App::make('PersonalBookInfoParameterMapper');
        $this->bookCreationService = App::make('BookCreationService');
    }

    public function executeStep($id = null)
    {
        $personalParams = $this->personalBookInfoParameterMapper->create();
        return $this->bookCreationService->savePersonalInformationForBook($id, $personalParams);
    }

    public function goToStep($id = null)
    {
        $withArray = BookFormFiller::fillForPersonalInfo($id);
        $withArray['title'] = 'Persoonlijke informatie';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        return View::make($this->bookFolder . 'personalinfo')->with($withArray);
    }
}