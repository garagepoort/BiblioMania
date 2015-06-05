<?php

class ImageUploader
{

    public function uploadImage($image)
    {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');

        $coverImage = null;
        $logger->info("Checking cover file...");
        if (Input::hasFile($image)) {
            $logger->info("Input file for cover image found. Uploading cover image");
            $file = Input::file($image);

            $userUsername = Auth::user()->username;
            $destinationPath = 'bookImages/' . $userUsername;

            $filename = $file->getClientOriginalName();
            $filename = str_random(8) . '_' . $filename;
            $upload_success = Input::file($image)->move($destinationPath, $filename);

            if ($upload_success == false) {
                $logger->info("Uploading of coverImage failed!!");
                return Redirect::to('/createBook')->withErrors(array('book_cover_image' => 'Cover image could not be uploaded'))->withInput();
            }
            $coverImage = $destinationPath . '/' . $filename;
        } else {
            $coverImage = 'images/questionCover.png';
        }

        return $coverImage;
    }
}