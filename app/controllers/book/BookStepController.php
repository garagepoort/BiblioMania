<?php

use Bendani\PhpCommon\WizardService\Controllers\StepController;

class BookStepController extends StepController
{
    public function getWizard(){
        return new BookWizard();
    }

    public function getBookWizard(){
        $steps = array_map(function($item, $index){
            return array(
                "title"=>$item->getTitle(),
                "number"=>$index
            );
        }, $this->getWizard()->getAllSteps(), array_keys($this->getWizard()->getAllSteps()));
        return $steps;
    }
}