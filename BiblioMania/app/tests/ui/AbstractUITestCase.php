<?php

class AbstractUITestCase extends AbstractIntegrationTestCase
{
    /** @var RemoteWebDriver $driver*/
    public $host;
    public $driver;
    public $userService;

    public function setUp(){
        parent::setUp();

        $this->userService = App::make('UserService');
        $this->host = 'http://localhost:4444/wd/hub';
        $capabilities = DesiredCapabilities::firefox();
        $this->driver = RemoteWebDriver::create($this->host, $capabilities, 5000);

    }

    public function login($email, $password){
        $this->driver->get('http://localhost:8888/BiblioMania/login');
        $this->assertAtPage('Login');

        $emailInput = $this->findElementById('usernameInputLogin');
        $passwordInput = $this->findElementById('passwordInputLogin');
        $loginButton = $this->findElementById('loginButton');

        $emailInput->sendKeys($email);
        $passwordInput->sendKeys($password);
        $loginButton->click();
    }

    public function assertElementNotDisplayed($id){
        try {
            $this->findElementById($id);
        } catch (NoSuchElementException $e) {
            return;
        }
        $this->fail("The element $id should not exist.");
    }

    public function assertElementDisplayed($id){
        try {
            $this->findElementById($id);
        } catch (NoSuchElementException $e) {
            $this->fail("The element $id was not found.");
        }
    }

    public function tearDown(){
        $full_screenshot = $this->takeScreenshot();
        $this->driver->quit();
    }

    public function findElementById($id){
        return $this->driver->findElement(WebDriverBy::id($id));
    }

    public function setValueOfInputField($id, $value){
        $this->findElementById($id)->clear();
        $this->findElementById($id)->sendKeys($value);
    }

    public function assertAtPage($pageTitle){
        $this->driver->wait(10, 500)->until(
          WebDriverExpectedCondition::titleIs($pageTitle)
        );
    }

     public function takeScreenshot($element=null){

        // Change the Path to your own settings
        $screenshot = "app/tests/ui/screenshots/" . time() . ".png";

        // Change the driver instance
        $this->driver->takeScreenshot($screenshot);
        if(!file_exists($screenshot)){
            throw new Exception('Could not save screenshot');
        }

        if(!(bool)$element){
            return $screenshot;
        }

        $element_screenshot = "app/tests/ui/screenshots/" . time() . ".png"; // Change the path here as well

        $element_width = $element->getSize()->getWidth();
        $element_height = $element->getSize()->getHeight();

        $element_src_x = $element->getLocation()->getX();
        $element_src_y = $element->getLocation()->getY();

        // Create image instances
        $src = imagecreatefrompng($screenshot);
        $dest = imagecreatetruecolor($element_width, $element_height);

        // Copy
        imagecopy($dest, $src, 0, 0, $element_src_x, $element_src_y, $element_width, $element_height);

        imagepng($dest, $element_screenshot);

        // unlink($screenshot); // unlink function might be restricted in mac os x.

        if(!file_exists($element_screenshot)){
            throw new Exception('Could not save element screenshot');
        }

        return $element_screenshot;
    }
}
?>