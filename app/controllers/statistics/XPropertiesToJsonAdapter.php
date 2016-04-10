<?php

class XPropertiesToJsonAdapter
{

    public static function createXProperty($name, $key){
        return array("name"=>$name, "key"=>$key);
    }

}