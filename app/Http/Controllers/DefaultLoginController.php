<?php

use Bendani\PhpCommon\LoginService\Controllers\LoginController;

class DefaultLoginController extends LoginController {

    public function getLoginPage()
    {
        return View::make('login')->with(array('title' => 'Login'));
    }

    /** @var  PermissionService  */
    private $permissionService;

    public function __construct()
    {
        $this->permissionService = App::make('PermissionService');
    }

    public function doLogin(){
        $userdata = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        if(Auth::attempt($userdata)){
            $user = Auth::user();
            if(!$user->activated){
                return Response::json(array(
                    'code'      =>  403,
                    'message'   =>  'User not activated'
                ), 403);
            }

            $userToJsonAdapter = new UserToJsonAdapter($user, $this->permissionService->getPermissionsForUser($user->id));
            return $userToJsonAdapter->mapToJson();
        }else{
            return Response::json(array(
                'code'      =>  401,
                'message'   =>  'Login failed: username password combination incorrect.'
            ), 401);
        }
    }
}