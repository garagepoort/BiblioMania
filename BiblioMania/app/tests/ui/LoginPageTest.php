<?php

class LoginPageTest extends AbstractUITestCase
{ 
    public function testLogin_success_redirectsToGetTenantsPage()
    {
        $this->driver->get('http://localhost:8888/BiblioMania/login');
        $this->assertAtPage('Login');

        $emailInput = $this->findElementById('emailInputLogin');
        $passwordInput = $this->findElementById('passwordInputLogin');
        $loginButton = $this->findElementById('loginButton');

        $emailInput->sendKeys('testUserTests@bendani.com');
        $passwordInput->sendKeys('xxx');
        $loginButton->click();

        $this->assertAtPage('Boeken');
    }

    public function testLogin_fails_showErrorMesage()
    {
        $this->driver->get('http://localhost:8888/BiblioMania/login');
        $this->assertAtPage('Login');

        $emailInput = $this->findElementById('emailInputLogin');
        $passwordInput = $this->findElementById('passwordInputLogin');
        $loginButton = $this->findElementById('loginButton');

        $emailInput->sendKeys('testUserTests@bendani.com');
        $passwordInput->sendKeys('wrongpass');
        $loginButton->click();

        $this->assertAtPage('Login');

        $this->assertElementDisplayed('loginAlertMessage');
    }
}
?>