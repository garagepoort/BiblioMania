<?php

class BookStepController extends BaseController
{
    private $bookWizard;

    public function __construct()
    {
        $this->bookWizard = new BookWizard();
    }

    public function get($step, $id = null){
        return $this->bookWizard->goToStep($id, $step);
    }

    public function save($step, $id = null){
        return $this->bookWizard->executeStep($id, $step);
    }
}