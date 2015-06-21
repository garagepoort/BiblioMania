<?php

class ImageService
{

    public function saveUploadImageForAuthor($image, $filename){
        $filename = str_random(8) . '_' . $filename . '.jpg';
        $filename = StringUtils::clean($filename);

        $image->move(Config::get("properties.authorImagesLocation"), $filename);
        return $filename;
    }

    public function saveUploadImageForBook($image, $filename){
        $filename = str_random(8) . '_' . $filename . '.jpg';
        $image->move(Config::get("properties.bookImagesLocation"). "/" . Auth::user()->username, $filename);
        return $filename;
    }

    public function saveImageFromUrl($url, $imageLocation)
    {
        $img = file_get_contents($url);
        $im = imagecreatefromstring($img);
        $width = imagesx($im);
        $height = imagesy($im);
        $newwidth = '142';
        $newheight = '226';

        $thumb = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $imageFilename = str_random(8) . '_' . $imageLocation . '.jpg';
        $imageFilename = StringUtils::clean($imageFilename);
        $imageLocation = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . '/' . $imageFilename;
        imagejpeg($thumb, $imageLocation); //save image as jpg

        imagedestroy($thumb);

        imagedestroy($im);
        return $imageFilename;
    }

    public function removeImage($image)
    {
        if (file_exists($image)) {
            unlink($image);
        }
    }

}