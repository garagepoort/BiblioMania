<?php

use Bendani\PhpCommon\WizardService\Controllers\StepController;

class BookStepController extends StepController
{
    public function __construct()
    {
        parent::__construct(new BookWizard());
    }

}