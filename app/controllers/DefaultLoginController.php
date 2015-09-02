<?php

use Bendani\PhpCommon\LoginService\Controllers\LoginController;

class DefaultLoginController extends LoginController {

    public function getLoginPage()
    {
        return View::make('login')->with(array('title' => 'Login'));
    }

    public function redirectAfterLogin()
    {
        if(Agent::isMobile() || Agent::isTablet()){
            return Redirect::to('getBooksList');
        }else{
            return Redirect::to('getBooks');
        }
    }
}