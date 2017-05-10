<?php
use Illuminate\Support\Facades\Response;

class ResponseCreator {


    public static function createInternalExceptionResponse(Exception $e, $code){
        return Response::json(array(
            'code'      =>  $code,
            'message'   =>  $e->getMessage()
        ), $code);
    }

    public static function createExceptionResponse(Exception $e){
        return Response::json(array(
            'code'      =>  412,
            'message'   =>  $e->getMessage()
        ), 412);
    }

    public static function createUnauthorizedResponse(){
        return Response::json(array(
            'code'      =>  401,
            'message'   =>  "User is not authorized."
        ), 401);
    }

    public static function createIdResponse($id){
        return Response::json(array('success' => true, 'id' => $id), 200);
    }
}