<?php

use Bendani\PhpCommon\Utils\Ensure;

class UserService
{

    /** @var UserRepository $userRepository */
    private $userRepository;
    /** @var RoleRepository $roleRepository */
    private $roleRepository;

    /**
     * UserService constructor.
     */
    public function __construct()
    {
        $this->userRepository = App::make('UserRepository');
        $this->roleRepository = App::make('RoleRepository');
    }


    public function saveUser($user)
    {
        return $this->userRepository->saveUser($user);
    }

    public function createUser(CreateUserRequest $createUserRequest)
    {
        Ensure::stringNotBlank('username', $createUserRequest->getUsername());
        Ensure::stringNotBlank('password', $createUserRequest->getPassword());
        Ensure::stringNotBlank('email', $createUserRequest->getEmail());

        $foundUser = $this->userRepository->findByUsername($createUserRequest->getUsername());
        Ensure::objectNull('user', $foundUser, 'user.with.username.exists');

        $user = new User();
        $user->username = $createUserRequest->getUsername();
        $user->password = Hash::make($createUserRequest->getPassword());
        $user->email = $createUserRequest->getEmail();

        $user= $this->userRepository->saveUser($user);

        $role = $this->roleRepository->findByName(RoleEnum::USER);
        $user->roles()->attach($role);

        return $user;
    }

}