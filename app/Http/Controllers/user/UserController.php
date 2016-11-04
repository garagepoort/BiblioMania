<?php

class UserController extends Controller{

    /** @var UserService $userService */
    private $userService;
    /** @var PermissionService $permissionService */
    private $permissionService;
    /** @var JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = App::make('UserService');
        $this->permissionService = App::make('PermissionService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }


    public function goToCreateUser() {
        return View::make('createUser')->with(array('title' => 'Create user'));
    }

    public function getLoggedInUser(){
        /** @var User $user */
        $user = Auth::user();
        $userToJsonAdapter = new UserToJsonAdapter($user, $this->permissionService->getPermissionsForUser($user->id));
        return $userToJsonAdapter->mapToJson();
    }

    public function createUser() {
        /** @var CreateUserFromJsonAdapter $user */
        $user = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateUserFromJsonAdapter());

        $this->userService->createUser($user);
    }


}
