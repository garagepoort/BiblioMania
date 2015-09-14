<?php

use Bendani\PhpCommon\WizardService\Model\WizardStep;

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
        $withArray['currentStep'] = $this;
        $withArray['title'] = $withArray['book_title'];
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        $withArray['covers'] = $covers;
        return View::make($this->bookFolder . 'cover')->with($withArray);
    }

    public function getTitle()
    {
        return "Cover";
    }
}