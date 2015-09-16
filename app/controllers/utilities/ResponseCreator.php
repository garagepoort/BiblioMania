<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 26/05/15
 * Time: 08:14
 */

class ResponseCreator {

    public static function createExceptionResponse(Exception $e){
        return Response::json(array(
            'code'      =>  412,
            'message'   =>  $e->getMessage()
        ), 412);
    }
}