<?php
use Illuminate\Support\Facades\Response;

class ResponseCreator {

    public static function createExceptionResponse(Exception $e){
        return Response::json(array(
            'code'      =>  412,
            'message'   =>  $e->getMessage()
        ), 412);
    }

    public static function createUnauthorizedResponse(){
        return Response::json(array(
            'code'      =>  401,
            'message'   =>  "User is not logged in."
        ), 401);
    }
}