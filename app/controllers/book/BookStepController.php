<?php

use Bendani\PhpCommon\WizardService\Controllers\StepController;

class BookStepController extends StepController
{
    public function getWizard(){
        return new BookWizard();
    }
}