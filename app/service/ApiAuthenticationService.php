<?php

class ApiAuthenticationService {


    public function getUser(){
        return JWTAuth::parseToken()->authenticate();
    }
    /**
     * @return null
     */
    public function checkUserAuthenticated()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return Response::json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return Response::json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return Response::json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return Response::json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return null;
    }


}