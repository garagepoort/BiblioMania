<?php

class FileToCoverInfoParametersMapper {

    public function map($line_values){
        $coverImage = null;
        if($line_values[LineMapping::CoverInfoImagePath] != ""){
            $path = explode('\\', $line_values[LineMapping::CoverInfoImagePath]);
            $coverImage = 'bookImages/' . Auth::user()->username . '/' . end($path);
        }

        return new CoverInfoParameters($line_values[LineMapping::CoverInfoType], $coverImage, ImageSaveType::PATH);
    }
}