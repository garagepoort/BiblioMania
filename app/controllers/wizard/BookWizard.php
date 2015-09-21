<?php

use Bendani\PhpCommon\WizardService\Model\Wizard;

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

    public function afterLastStepGoTo($result)
    {
        return Redirect::to('/getBooks?scroll_id=' . $result->id);
    }

    protected function onFailureGoTo(){
        return Redirect::to('/getBooks');
    }

    public function onEnterNextStep($result, $currentStep)
    {
        $this->bookService->setWizardStep($result, $currentStep + 1);
    }

    protected function onFinishLastStep($object)
    {
        $this->bookService->completeWizard($object);
    }

}