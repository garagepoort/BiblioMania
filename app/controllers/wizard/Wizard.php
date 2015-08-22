<?php

abstract class Wizard
{

    /** @var WizardStep array */
    protected $wizardSteps = array();

    protected $basePath;

    public function __construct(array $wizardSteps, $basePath)
    {
        $this->wizardSteps = $wizardSteps;
        foreach($this->wizardSteps as $key => $step){
            $stepNumber = $key + 1;
            $step->setUrl($basePath . "/step/" . $stepNumber . "/");
            $step->setStepNumber($stepNumber);
        }
        $this->basePath = $basePath;
    }

    public function goToStep($book_id, $step){
        if(!$this->checkIsAllowedToBeInStep($book_id, $step)){
            return $this->onFailureGoTo();
        }
        /** @var WizardStep $wizardStep */
        $wizardStep = $this->wizardSteps[$step - 1];
        return $wizardStep->goToStep($book_id);
    }

    public function executeStep($book_id, $step)
    {
        /** @var WizardStep $wizardStep */
        $wizardStep = $this->wizardSteps[$step - 1];

        if ($this->checkIsAllowedToBeInStep($book_id, $step)) {
            $result = $wizardStep->executeStep($book_id);
            if ($wizardStep->hasErrors() == false) {
                return $this->goToCorrectNextStep($result->id, $step, $result);
            } else {
                return $this->goToCurrentStepWithErrors($book_id, $result, $step);
            }
        } else {
            return $this->onFailureGoTo();
        }
    }

    public function isLastStep($step)
    {
        return $step == count($this->wizardSteps);
    }

    public function goToNextStep($id, $currentStep){
        $nextStep = $currentStep + 1;
        return Redirect::to("/" . $this->basePath . "/step/" . $nextStep ."/" . $id);
    }

    public function goToCurrentStepWithErrors($id, $validator, $currentStep){
        return Redirect::to("/" . $this->basePath . "/step/". $currentStep ."/" . $id)->withErrors($validator)->withInput();
    }

    public function goToPreviousStep($id, $currentStep){
        $previousStep = $currentStep - 1;
        return Redirect::to("/" . $this->basePath . "/step/" . $previousStep ."/" . $id);
    }

    public function redirectToStep($id, $step){
        return Redirect::to("/" . $this->basePath . "/step/" . $step ."/" . $id);
    }

    public abstract function afterLastStepGoTo();

    protected abstract function checkIsAllowedToBeInStep($object, $step);
    protected abstract function beforeGoingToNextStep($object, $currentStep);
    protected abstract function beforeGoingToLastStep($object);
    protected abstract function onFailureGoTo();

    /**
     * @param $book_id
     * @param $step
     * @param $result
     * @return mixed
     */
    public function goToCorrectNextStep($book_id, $step, $result)
    {
        $redirectTo = Input::get('redirect');
        if ($redirectTo == "PREVIOUS") {
            return $this->goToPreviousStep($book_id, $step);
        } else if($redirectTo == "NEXT"){
            if ($this->isLastStep($step)) {
                $this->beforeGoingToLastStep($result);
                return $this->afterLastStepGoTo();
            } else {
                $this->beforeGoingToNextStep($result, $step);
                return $this->goToNextStep($book_id, $step);
            }
        }else{
            return $this->redirectToStep($book_id, $redirectTo);
        }
    }
}