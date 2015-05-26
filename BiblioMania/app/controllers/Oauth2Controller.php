<?php
/**
 * Created by PhpStorm.
 * User: davidm
 * Date: 28/02/14
 * Time: 21:35
 */

class Oauth2_Controller extends BaseController{

     public function doGoogleAuthentication(){
        $logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

        $client = new Google_Client();
        $client->setClientId(Config::get('googleAPI.client_id'));
        $client->setClientSecret(Config::get('googleAPI.client_secret'));
        $client->setRedirectUri(Config::get('googleAPI.redirect_uri'));
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));

         if (isset($_GET['code'])) {
              $client->authenticate($_GET['code']);
              $logger->info("retrieved access token: [" . $client->getAccessToken() . "]");
              $logger->info("retrieved refresh token: [" . $client->getRefreshToken() . "]");
              Session::put('access_token', $client->getAccessToken());
              Session::put('refresh_token', $client->getRefreshToken());
              GoogleApiRepository::createOrUpdateApiTokenForUser(Auth::user()->username, $client->getAccessToken(), $client->getRefreshToken());
              $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
              header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
     }

     public function askForGoogleAuthentication(){
        $client_id = "1276984280-h0073puaeu1hsessboidrqmcsul6md0u.apps.googleusercontent.com";
        $client_secret = "LbrkX3ZnbgkiVbJXZMU2Hr_l";
        $redirect_uri = "http://localhost:8888/huurApp/googleAuthentication";

        $client = new Google_Client();
        $client->setClientId(Config::get('googleAPI.client_id'));
        $client->setClientSecret(Config::get('googleAPI.client_secret'));
        $client->setRedirectUri(Config::get('googleAPI.redirect_uri'));
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setAccessType('offline');

        $service = new Google_Service_Drive($client);

        $authUrl = $client->createAuthUrl();

        return Redirect::to($authUrl);
     }

     public function uploadFile(){

        $client = new Google_Client();
        $client->setClientId(Config::get('googleAPI.client_id'));
        $client->setClientSecret(Config::get('googleAPI.client_secret'));
        $client->setRedirectUri(Config::get('googleAPI.redirect_uri'));
        $client->setScopes(array('https://www.googleapis.com/auth/drive'));
        $client->setAccessType('offline');

        $client->setAccessToken(GoogleApiRepository::getAccessTokenFromUser(Auth::user()->username));

        $service = new Google_Service_Drive($client);

        //Insert a file
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle('My document');
        $file->setDescription('A test document');
        $file->setMimeType('text/plain');

        $data = file_get_contents('../jobs/hello.txt');

        $createdFile = $service->files->insert($file, array(
              'data' => $data,
              'mimeType' => 'text/plain',
              'uploadType' => 'media'
            ));

        print_r($createdFile);
    }
     
}