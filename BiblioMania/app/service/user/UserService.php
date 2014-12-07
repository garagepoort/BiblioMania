<?php

class UserService {

    public function saveUser($user){
        return App::make('UserRepository')->saveUser($user);
    }

    public function createUser($username, $email, $password){
        $user = new User();
        $user->password = Hash::make($password);
        $user->email = $email;;
        return App::make('UserRepository')->saveUser($user);
    }

}