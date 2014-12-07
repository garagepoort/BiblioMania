<?php
/**
 * Created by PhpStorm.
 * User: davidm
 * Date: 28/02/14
 * Time: 21:35
 */

class User_Controller extends BaseController{

    public function goToCreateUser() {
        return View::make('createUser');
    }

    public function createUser() {
        $userService = App::make('UserService');
        if(Auth::user()->admin == false){
            return Redirect::to('getBooks');
        }
        $userdata = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        $user = new User();
        $password = Input::get('password');
        $confirmPassword = Input::get('confirmPassword');

        if(strcmp ($password, $confirmPassword) == 0){
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $userService->saveUser($user);
            return Redirect::to('login');
        }else{
            return Redirect::to('createUser')->with('message', 'Passwords aren\'t equal.');
        }
    }


}
