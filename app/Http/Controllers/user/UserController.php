<?php

class UserController extends Controller{

    /** @var UserService $userService */
    private $userService;
    /** @var JsonMappingService $jsonMappingService */
    private $jsonMappingService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = App::make('UserService');
        $this->jsonMappingService = App::make('JsonMappingService');
    }


    public function goToCreateUser() {
        return View::make('createUser')->with(array('title' => 'Create user'));
    }

    public function getLoggedInUser(){
        $userToJsonAdapter = new UserToJsonAdapter(Auth::user());
        return $userToJsonAdapter->mapToJson();
    }

    public function createUser() {
        /** @var CreateUserFromJsonAdapter $user */
        $user = $this->jsonMappingService->mapInputToJson(Input::get(), new CreateUserFromJsonAdapter());

        $this->userService->createUser($user);
    }


}
