<?php

class UserRepository {

    public function saveUser($user){
        App::make('Logger')->info('Repository: Saving user: '. $user->username);
        $user->save();
        App::make('Logger')->info('Repository: user saved');
        return $user;   
    }

    /**
     * @param $user_id
     * @return User
     */
    public function find($user_id){
        return User::find($user_id);
    }

}