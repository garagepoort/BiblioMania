<?php

class UserService
{

    /** @var UserRepository $userRepository */
    private $userRepository;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->userRepository = App::make('UserRepository');
    }


    public function saveUser($user)
    {
        return $this->userRepository->saveUser($user);
    }

    public function createUser(CreateUserRequest $createUserRequest)
    {
        $user = new User();
        $user->username = $createUserRequest->getUsername();
        $user->password = Hash::make($createUserRequest->getPassword());
        $user->email = $createUserRequest->getEmail();
        return $this->userRepository->saveUser($user);
    }

}