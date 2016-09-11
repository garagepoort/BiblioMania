<?php

use Bendani\PhpCommon\LoginService\Controllers\LoginController;

class DefaultLoginController extends LoginController {

    public function getLoginPage()
    {
        return View::make('login')->with(array('title' => 'Login'));
    }
}