<?php

class OeuvreWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
    }

    public function executeStep($id = null)
    {
//        $coverInfoParameters = $this->coverInfoParameterMapper->create();
//        return $this->bookCreationService->saveCoverInfoToBook($id, $coverInfoParameters);
        return $this->bookService->find($id);
    }

    public function goToStep($id = null)
    {
        $book = $this->bookService->find($id);
        $withArray['currentStep'] = $this;
        $withArray['title'] = $book->title;
        $withArray['book_id'] = $book->id;
        $withArray['book_wizard_step'] = $book->wizard_step;
        $withArray['oeuvre'] = $book->preferredAuthor()->oeuvre;
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        return View::make($this->bookFolder . 'oeuvre')->with($withArray);
    }
}