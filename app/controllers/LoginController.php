<?php

class LoginController extends BaseController {

	public function goToLogin()
	{
		return View::make('login')->with(array('title' => 'Login'));
	}

 	public function login(){
         $userdata = array(
             'username' => Input::get('username'),
             'password' => Input::get('password')
         );
         if(Auth::attempt($userdata)){
             return Redirect::to('getBooks');
         }else{
             return Redirect::to('login')
                 ->with('message', 'Login failed: username password combination incorrect.');
         }
     }

    public function logOut(){
        Auth::logout();
        return Redirect::to('login');
    }
}