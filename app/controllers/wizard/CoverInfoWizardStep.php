<?php

class CoverInfoWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  CoverInfoParameterMapper */
    private $coverInfoParameterMapper;
    /** @var  BookCreationService */
    private $bookCreationService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->coverInfoParameterMapper = App::make('CoverInfoParameterMapper');
        $this->bookCreationService = App::make('BookCreationService');
    }

    public function executeStep($id = null)
    {
        $coverInfoParameters = $this->coverInfoParameterMapper->create();
        return $this->bookCreationService->saveCoverInfoToBook($id, $coverInfoParameters);
    }

    public function goToStep($id = null)
    {
        $covers = $this->bookService->getBookCoverTypes();
        $withArray = BookFormFiller::fillForCover($id);
        $withArray['title'] = 'Cover';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps();
        $withArray['covers'] = $covers;
        return View::make($this->bookFolder . 'cover')->with($withArray);
    }
}