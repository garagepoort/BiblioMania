<?php

abstract class WizardStep
{
    protected $hasErrors = false;

    public abstract function executeStep($object = null);

    public abstract function goToStep($object = null);


    public function hasErrors()
    {
        return $this->hasErrors;
    }
}