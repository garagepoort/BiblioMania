<?php

abstract class WizardStep
{
    protected $hasErrors = false;
    public $url = "";
    public $stepNumber;

    public abstract function executeStep($object = null);

    public abstract function goToStep($object = null);


    public function hasErrors()
    {
        return $this->hasErrors;
    }

    public function setUrl($url){
        $this->url = $url;
    }
    public function setStepNumber($stepNumber){
        $this->stepNumber = $stepNumber;
    }
}