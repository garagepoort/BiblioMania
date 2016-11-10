<?php

class UserRepository {

    public function saveUser($user){
        $user->save();
        return $user;
    }

    public function find($user_id){
        return User::find($user_id);
    }

    public function findByUsername($username) {
        return User::where('username', '=', $username)->first();
    }

}