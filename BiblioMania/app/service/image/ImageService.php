<?php
class ImageService {

    public function getImageFromUrl($url, $filename){
        $img = file_get_contents($url);
        $im = imagecreatefromstring($img);
        $width = imagesx($im);
        $height = imagesy($im);
        $newwidth = '142';
        $newheight = '226';

        $thumb = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $filename = 'bookImages/' . Auth::user()->username . '/' . str_random(8). '_' .$filename.'.jpg';
        imagejpeg($thumb, $filename); //save image as jpg

        imagedestroy($thumb);

        imagedestroy($im);

        return $filename;
    }
}