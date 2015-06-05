<?php

class LoginPageTest extends AbstractUITestCase
{ 
    public function testLogin_success_redirectsToGetTenantsPage()
    {
        $this->login("testUserTests@bendani.com", "xxx");

        $this->assertAtPage('Boeken');
    }

    public function testLogin_fails_showErrorMesage()
    {
        $this->login("testUserTests@bendani.com", "wrongpass");
        $this->assertAtPage('Login');
        $this->assertElementDisplayed('loginAlertMessage');
    }
}
?>