<?php

class XPropertiesToJsonAdapter
{

    public function mapToJson($xproperties){
        $result = array();
        foreach($xproperties as $xproperty){
            array_push($result, array("name" => $xproperty));
        }
        return $result;
    }
}