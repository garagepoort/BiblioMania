<?php

class ImageService
{

    public function saveUploadImageForAuthor($image, $filename){
        $filename = str_random(8) . '_' . $filename . '.jpg';
        $location = Config::get("properties.authorImagesLocation") .  "/" . $filename;
        $image->move(Config::get("properties.authorImagesLocation"), $filename);
        $image = imagecreatefromjpeg($location);
        $this->resizeAndSaveImage($location, $image);
        return $filename;
    }

    public function saveUploadImageForBook($image, $filename){
        $filename = str_random(8) . '_' . $filename . '.jpg';
        $location = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . "/" . $filename;
        $image->move(Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username, $filename);
        $image = imagecreatefromjpeg($location);
        $this->resizeAndSaveImage($location, $image);
        return $filename;
    }

    public function saveAuthorImageFromUrl($url, $imageLocation)
    {
       return $this->saveImageFromUrl($url, $imageLocation, Config::get("properties.authorImagesLocation"));
    }

    public function saveBookImageFromUrl($url, $imageLocation)
    {
        return $this->saveImageFromUrl($url, $imageLocation, Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username);
    }

    public function saveImageFromUrl($url, $imageLocation, $folder)
    {
        $img = file_get_contents($url);
        $im = imagecreatefromstring($img);
        $newwidth = '142';
        $newheight = '226';

        $newImage = $this->resize_image_max($im, $newwidth, $newheight);
        $imageFilename = str_random(8) . '_' . $imageLocation . '.jpg';
        $imageFilename = StringUtils::clean($imageFilename);
        $imageLocation = $folder . '/' . $imageFilename;
        imagejpeg($newImage, $imageLocation); //save image as jpg

        imagedestroy($newImage);
        imagedestroy($im);
        return $imageFilename;
    }

    function resizeAndSaveImage($location, $image){
        $newwidth = '142';
        $newheight = '226';
        $newImage = $this->resize_image_max($image, $newwidth, $newheight);
        imagejpeg($newImage, $location); //save image as jpg
        imagedestroy($image);
        imagedestroy($newImage);
    }

    public function removeAuthorImage($image)
    {
        $fullImagePath = Config::get("properties.authorImagesLocation") . "/" . $image;
        if(!StringUtils::isEmpty($image)){
            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
            }
        }
    }

    public function removeBookImage($image)
    {
        $fullImagePath = Config::get("properties.bookImagesLocation") . "/" . $image;
        if(!StringUtils::isEmpty($image)) {
            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
            }
        }
    }

    function resize_image_max($image,$max_width,$max_height) {
        $w = imagesx($image); //current width
        $h = imagesy($image); //current height
        if ((!$w) || (!$h)) { $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.'; return false; }

        if (($w <= $max_width) && ($h <= $max_height)) { return $image; } //no resizing needed

        //try max height first...
        $ratio = $max_height / $h;
        $new_h = $max_height;
        $new_w = $w * $ratio;

        //if that didn't work
        if ($new_w > $max_width) {
            $ratio = $max_width / $w;
            $new_w = $max_width;
            $new_h = $h * $ratio;
        }

        $new_image = imagecreatetruecolor ($new_w, $new_h);
        imagecopyresampled($new_image,$image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        return $new_image;
    }

}