<?php

class Page {
    /** @var RemoteWebDriver $driver*/
    protected $driver;

    function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function setValueOfInputField($id, $value){
        $this->findElementById($id)->clear();
        $this->findElementById($id)->sendKeys($value);
    }

    public function findElementById($id){
        return $this->driver->findElement(WebDriverBy::id($id));
    }

}