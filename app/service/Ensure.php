<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class Ensure
{

    public static function stringNotBlank($field, $string){
        if(StringUtils::isEmpty($string)){
            throw new ServiceException("Field " . $field . " can not be empty.");
        }
    }

    public static function objectNotNull($field, $object){
        if($object == null){
            throw new ServiceException("Object " . $field . " can not be null.");
        }
    }

}