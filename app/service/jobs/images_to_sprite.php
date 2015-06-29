<?php
class images_to_sprite {
    const SPRITE = "sprite";
    const WIDTH = "142";

    public static function create_sprite_for_book_images($folder, $user) {
        $heightSprite = 0;
        $images = array();
        $filetypes = array('jpg'=>true);

        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        // Read through the directory for suitable images
        if($handle = opendir($folder)) {
            while (false !== ($file = readdir($handle))) {
                $split = explode('.',$file);
                // Ignore non-matching file extensions
                if($file[0] == '.' || !isset($filetypes[$split[count($split)-1]]))
                    continue;
                // Get image size and ensure it has the correct dimensions
                $output = getimagesize($folder.'/'.$file);
                if($output[0] != self::WIDTH)
                    continue;

                // Image will be added to sprite, add to array
                $logger->info("FILE TYPE: " . $output["mime"]);
                $height = $output[1];
                array_push($images, new Image(self::WIDTH, $height, $file));
                $heightSprite = $heightSprite + $height;
            }
            closedir($handle);
        }

        $im = imagecreatetruecolor(self::WIDTH, $heightSprite);

        imagesavealpha($im, true);
        $alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im,0,0,$alpha);

        $imageYPointer = 0;
        /** @var Image $image */
        foreach($images as $image) {
            $book = Book::where('coverImage', '=', $image->getFile())
                ->where('user_id', "=", $user->id)
                ->first();
            if($book != null){
                $book->spritePointer = $imageYPointer;
                $book->imageHeight = $image->getHeight();
                $book->useSpriteImage = true;
                $book->save();
            }

            $im2 = imagecreatefromjpeg($folder.'/'.$image->getFile());
            imagecopy($im, $im2, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
            imagedestroy($im2);
            $imageYPointer = $imageYPointer + $image->getHeight();
        }
        imagepng($im, $folder . '/' .self::SPRITE.'.png', 9, PNG_ALL_FILTERS); // Save image to file
        imagedestroy($im);
    }

    public static function create_sprite_for_author_images($folder) {
        $heightSprite = 0;
        $images = array();
        $filetypes = array('jpg'=>true);

        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        // Read through the directory for suitable images
        if($handle = opendir($folder)) {
            while (false !== ($file = readdir($handle))) {
                $split = explode('.',$file);
                // Ignore non-matching file extensions
                if($file[0] == '.' || !isset($filetypes[$split[count($split)-1]]))
                    continue;
                // Get image size and ensure it has the correct dimensions
                $output = getimagesize($folder.'/'.$file);
                if($output[0] != self::WIDTH)
                    continue;

                // Image will be added to sprite, add to array
                $logger->info("FILE TYPE: " . $output["mime"]);
                $height = $output[1];
                array_push($images, new Image(self::WIDTH, $height, $file));
                $heightSprite = $heightSprite + $height;
            }
            closedir($handle);
        }

        $im = imagecreatetruecolor(self::WIDTH, $heightSprite);

        // Add alpha channel to image (transparency)
        imagesavealpha($im, true);
        $alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im,0,0,$alpha);

        // Append images to sprite and generate CSS lines

        $fp = fopen($folder . '/' .self::SPRITE .'.css','w');
        $imageYPointer = 0;
        /** @var Image $image */
        $counter = 0;
        foreach($images as $image) {
            $author = Author::where('image', '=', $image->getFile())
                ->first();
            if($author != null){
                $author->spritePointer = $imageYPointer;
                $author->imageHeight = $image->getHeight();
                $author->useSpriteImage = true;
                $author->save();
            }

            fwrite($fp,'.'.self::SPRITE.$imageYPointer.' { background-position: -0px -'.$imageYPointer.'px; }'."\n");
            $im2 = imagecreatefromjpeg($folder.'/'.$image->getFile());
            imagecopy($im, $im2, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
            imagedestroy($im2);
            $imageYPointer = $imageYPointer + $image->getHeight();
        }
        fclose($fp);
        imagepng($im, $folder . '/' .self::SPRITE.'.png', 9, PNG_ALL_FILTERS); // Save image to file
        imagedestroy($im);
    }

    static function addToSprite($spritePath, $imagePath){
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        $outputSprite = getimagesize($spritePath);
        $outputImage = getimagesize($imagePath);

        $spriteWidth = $outputSprite[0];
        $spriteHeight = $outputSprite[1];
        $imageHeight = $outputImage[1];

        $spriteImage = imagecreatefrompng($spritePath);
        $image = imagecreatefromjpeg($imagePath);

        $im = imagecreatetruecolor($spriteWidth,$spriteHeight + $imageHeight);

        imagecopy($im, $spriteImage, 0, 0, 0, 0, $spriteWidth, $spriteHeight);
        imagecopy($im, $image, 0, $spriteHeight, 0, 0, $spriteWidth, $imageHeight);

        imagepng($im,$spritePath); // Save image to file

        imagedestroy($im);

        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }
}