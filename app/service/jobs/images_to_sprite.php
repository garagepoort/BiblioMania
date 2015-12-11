<?php
class images_to_sprite {
    const SPRITE = "sprite";
    const WIDTH = 142;

    public static function create_sprite_for_book_images($folder, $user) {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        list($images, $heightSprite) = self::getImagesFromFolder($folder, $logger);

        $spriteImage = imagecreatetruecolor(self::WIDTH, $heightSprite);

        imagesavealpha($spriteImage, true);
        $alpha = imagecolorallocatealpha($spriteImage, 0, 0, 0, 127);
        imagefill($spriteImage,0,0,$alpha);

        $imageYPointer = 0;
        /** @var Image $image */
        foreach($images as $image) {
            $logger->info("Found file: " . $image->getFile());
            $book = Book::where('coverImage', '=', $image->getFile())->first();
            if($book != null){
                $book->spritePointer = $imageYPointer;
                $book->imageHeight = $image->getHeight();
                $book->imageWidth = $image->getWidth();
                $book->useSpriteImage = true;
                $book->save();
            }

            $bookImage = imagecreatefromjpeg($folder.'/'.$image->getFile());
            imagecopy($spriteImage, $bookImage, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
            imagedestroy($bookImage);
            $imageYPointer = $imageYPointer + $image->getHeight();
        }
        imagepng($spriteImage, $folder . '/' .self::SPRITE.'.png', 9, PNG_ALL_FILTERS); // Save image to file
        imagedestroy($spriteImage);
    }

    public static function create_sprite_for_author_images($folder) {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        list($images, $heightSprite) = self::getImagesFromFolder($folder, $logger);

        $im = imagecreatetruecolor(self::WIDTH, $heightSprite);

        imagesavealpha($im, true);
        $alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im,0,0,$alpha);

        $imageYPointer = 0;

        /** @var Image $image */
        foreach($images as $image) {
            $author = Author::where('image', '=', $image->getFile())
                ->first();
            if($author != null){
                $author->spritePointer = $imageYPointer;
                $author->imageHeight = $image->getHeight();
                $author->imageWidth = $image->getWidth();
                $author->useSpriteImage = true;
                $author->save();
            }

            $im2 = imagecreatefromjpeg($folder.'/'.$image->getFile());
            imagecopy($im, $im2, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
            imagedestroy($im2);
            $imageYPointer = $imageYPointer + $image->getHeight();
        }
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

    protected static function getImagesFromFolder($folder, $logger)
    {
        $fileTypes = array('jpg'=>true);
        $heightSprite = 0;
        $images = array();
        if ($handle = opendir($folder)) {
            while (false !== ($file = readdir($handle))) {
                $split = explode('.', $file);
                // Ignore non-matching file extensions
                if ($file[0] == '.' || !isset($fileTypes[$split[count($split) - 1]]))
                    continue;
                // Get image size and ensure it has the correct dimensions
                $output = getimagesize($folder . '/' . $file);

                // Image will be added to sprite, add to array
                $logger->info("FILE TYPE: " . $output["mime"]);
                $width = $output[0];
                $height = $output[1];
                array_push($images, new Image($width, $height, $file));
                $heightSprite = $heightSprite + $height;
            }
            closedir($handle);
            return array($images, $heightSprite);
        }
        return array($images, $heightSprite);
    }
}