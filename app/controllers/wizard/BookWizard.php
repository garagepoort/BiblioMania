<?php

use Bendani\PhpCommon\WizardService\Model\Wizard;
use Bendani\PhpCommon\WizardService\Model\WizardStep;

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

    protected function checkIsAllowedToBeInStep($id, WizardStep $stepToSave)
    {
        if($stepToSave->stepNumber == 1){
            return true;
        }
        $book = $this->bookService->find($id);
        if($book == null){
            return false;
        }

        $bookStep = $book->wizard_step;
        if ($bookStep != "COMPLETE" && $bookStep < $stepToSave->stepNumber) {
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

    public function onEnterNextStep($result, WizardStep $currentStep)
    {
        $this->bookService->setWizardStep($result, $currentStep->stepNumber + 1);
    }

    protected function onFinishLastStep($object)
    {
        $this->bookService->completeWizard($object);
    }

    public function getAllSteps(){
        return $this->wizardSteps;
    }

}