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

    public static function objectIsInstanceOf($field, $object, $className, $message = null)
    {
        Ensure::objectNotNull($field, $object);
        $interfaces = class_implements($object);
        if(!isset($interfaces[$className])){
            if($message == null){
                throw new ServiceException("Object " . $field . " must be of class " . $className);
            }else{
                throw new ServiceException($message);
            }
        }
    }

    public static function arrayHasLength($field, $value, $length, $message)
    {
        Ensure::objectIsArray($field, $value, $message);
        if(!count($value) === $length){
            if($message == null){
                throw new ServiceException("Array " . $field . " must have length " .  $length);
            }else{
                throw new ServiceException($message);
            }
        }
    }

    public static function objectIsArray($field, $object, $message = null){
        if(!is_array($object)){
            if($message == null){
                throw new ServiceException("Object " . $field . " must be an array.");
            }else{
                throw new ServiceException($message);
            }
        }
    }

}