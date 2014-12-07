<?php

class UserManager {

    // public static function isAdmin(){
    //     return Auth::user()->admin;
    // }

    public static function isLoggedIn(){
        return Auth::check();
    }
}