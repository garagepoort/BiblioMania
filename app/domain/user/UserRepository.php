<?php

class UserRepository {

    public function saveUser($user){
        App::make('Logger')->info('Repository: Saving user: '. $user->username);
        $user->save();
        App::make('Logger')->info('Repository: user saved');
        return $user;   
    }

}