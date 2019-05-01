<?php

class GoogleApiRepository {

    public static function createOrUpdateApiTokenForUser($username, $accessToken, $refreshToken){
        $logger = App::make('Logger');

        $token = GoogleApiToken::where('username', '=', $username)->first();
        
        if(isset($token)){
            $logger->info("updating api token for user: " . $username);
            if(isset($refreshToken)){
                $logger->info("updating api refresh token for user: " . $username);
                $token->refresh_token = $refreshToken;
            }

            $token->username = $username;
            $token->access_token = $accessToken;
        }else{
            $logger->info("saving api token for user: " . $username);
            $token = new GoogleApiToken(array(
                'username' => $username,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken
            ));
        }
        $token->save();
        $logger->info("Api token saved for user: " . $username);
        return $token;
    }

    public static function getAccessTokenFromUser($username){
        return GoogleApiToken::where('username', '=', $username)->first()->access_token;
    }

    public static function getRefreshTokenFromUser($username){
        return GoogleApiToken::where('username', '=', $username)->first()->refresh_token;
    }

}
