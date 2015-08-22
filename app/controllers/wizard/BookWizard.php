<?php

class BookWizard extends Wizard
{

    /** @var  BookService */
    private $bookService;

    public function __construct()
    {
        parent::__construct(array(
            new BookBasicsWizardStep(),
            new BookExtrasWizardStep(),
            new AuthorWizardStep(),
            new OeuvreWizardStep(),
            new FirstPrintWizardStep(),
            new PersonalInfoWizardStep(),
            new BuyOrGiftWizardStep(),
            new CoverInfoWizardStep()
        ), 'createOrEditBook');

        $this->bookService = App::make('BookService');
    }

    protected function checkIsAllowedToBeInStep($id, $stepToSave)
    {
        if($stepToSave == 1){
            return true;
        }
        $book = $this->bookService->find($id);
        if($book == null){
            return false;
        }

        $bookStep = $book->wizard_step;
        if ($bookStep != "COMPLETE" && $bookStep < $stepToSave) {
            return false;
        }
        return true;
    }

    public function afterLastStepGoTo()
    {
        return Redirect::to('/getBooks');
    }

    protected function onFailureGoTo(){
        return Redirect::to('/getBooks');
    }

    public function beforeGoingToNextStep($result, $currentStep)
    {
        $this->bookService->setWizardStep($result, $currentStep + 1);
    }

    protected function beforeGoingToLastStep($object)
    {
        $this->bookService->completeWizard($object);
    }
}