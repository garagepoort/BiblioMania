<?php

class AuthenticateController extends Controller
{

    public function index()
    {
        JWTAuth::parseToken()->authenticate();
        $users = User::all();
        return $users;
    }
    public function users()
    {
        $users = User::all();
        return $users;
    }

    public function authenticate()
    {
        // grab credentials from the request
        $credentials = Input::only('username', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                return Response::json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return Response::json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return Response::json(compact('token'));
    }
}