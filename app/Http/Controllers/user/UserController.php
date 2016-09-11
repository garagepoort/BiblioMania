<?php
/**
 * Created by PhpStorm.
 * User: davidm
 * Date: 28/02/14
 * Time: 21:35
 */

class UserController extends Controller{

    /** @var UserService $userService */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = App::make('UserService');
    }


    public function goToCreateUser() {
        return View::make('createUser')->with(array('title' => 'Create user'));
    }

    public function getLoggedInUser(){
        $userToJsonAdapter = new UserToJsonAdapter(Auth::user());
        return $userToJsonAdapter->mapToJson();
    }

    public function createUser() {
        $password = Input::get('password');
        $confirmPassword = Input::get('confirmPassword');

        if(strcmp ($password, $confirmPassword) == 0){
            $this->userService->createUser(Input::get('username'), Input::get('email'), Input::get('password'));
            return Redirect::to('login');
        }else{
            return Redirect::to('createUser')->with('message', 'Passwords aren\'t equal.');
        }
    }


}
