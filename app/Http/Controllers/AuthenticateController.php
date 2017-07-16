<?php

class AuthenticateController extends Controller
{

    /** ApiAuthenticationService $apiAuthenticationService */
    private $apiAuthenticationService;
    /** UserService $userService */
    private $userService;
    /** @var \Katzgrau\KLogger\Logger $logger */
    private $logger;


    function __construct()
    {
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
        $this->userService = App::make('UserService');
        $this->logger = App::make('Logger');
    }

    public function authenticate()
    {
        $this->logger->info("authenticate this");
//        // grab credentials from the request
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

        $user = $this->userService->getUserByUsername($credentials['username']);

        // all good so return the token
        return Response::json(compact(['token', 'user']));
    }
}