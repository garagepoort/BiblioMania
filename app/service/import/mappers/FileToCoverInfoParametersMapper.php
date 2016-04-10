<?php

use Bendani\PhpCommon\Utils\StringUtils;

class FileToCoverInfoParametersMapper {

    public function map($line_values){
        $coverImage = "";
        if($line_values[LineMapping::$CoverInfoImagePath] != ""){
            $path = explode('\\', $line_values[LineMapping::$CoverInfoImagePath]);
            $path =StringUtils::clean(end($path));
            $path = pathinfo($path);
            $path = $path['filename'] . ".jpg";


            if(file_exists('importImages/' . $path)){
                $coverImagePath = Config::get("properties.bookImagesLocation") . '/' . $path;
                $coverImage = $path;
                copy('importImages/' . $path, $coverImagePath);
            }
        }

        return new CoverInfoParameters($line_values[LineMapping::$CoverInfoType], $coverImage, ImageSaveType::PATH);
    }
}