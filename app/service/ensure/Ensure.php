<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class Ensure
{

    public static function stringNotBlank($field, $string, $message = null){
        if(StringUtils::isEmpty($string)){
            if($message == null){
                throw new ServiceException("Field " . $field . " can not be empty.");
            }else{
                throw new ServiceException($message);
            }
        }
    }

    public static function objectNotNull($field, $object, $message = null){
        if($object == null){
            if($message == null){
                throw new ServiceException("Object " . $field . " can not be null.");
            }else{
                throw new ServiceException($message);
            }
        }
    }

    public static function objectNull($field, $object, $message = null)
    {
        if($object != null){
            if($message == null){
                throw new ServiceException("Object " . $field . " must be null.");
            }else{
                throw new ServiceException($message);
            }
        }
    }

}