<?php
/**
 * Created by PhpStorm.
 * User: davidm
 * Date: 28/02/14
 * Time: 21:35
 */

class UserController extends BaseController{

    public function goToCreateUser() {
        return View::make('createUser')->with(array('title' => 'Create user'));
    }

    public function createUser() {
        $userService = App::make('UserService');
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
