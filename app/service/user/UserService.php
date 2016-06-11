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

    public function createUser($username, $email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->email = $email;
        return $this->userRepository->saveUser($user);
    }

}