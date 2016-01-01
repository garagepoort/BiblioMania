<?php
class SpriteCreator {
    const SPRITE = "sprite";
    const WIDTH = 142;

    /** @var  \Katzgrau\KLogger\Logger */
    private $logger;

    /**
     * SpriteCreator constructor.
     */
    public function __construct()
    {
        $this->logger = App::make('Logger');
    }


    public function createSpriteForImages($folder, $onImageFound) {
        list($images, $heightSprite) = self::getImagesFromFolder($folder);

        $spriteImage = imagecreatetruecolor(self::WIDTH, $heightSprite);
        imagesavealpha($spriteImage, true);
        $alpha = imagecolorallocatealpha($spriteImage, 0, 0, 0, 127);
        imagefill($spriteImage,0,0,$alpha);

        $imageYPointer = 0;
        /** @var Image $image */
        foreach($images as $image) {
            if(exif_imagetype($folder .'/'. $image->getFile()) === IMAGETYPE_JPEG){
                $this->logger->info("Found file: " . $image->getFile());
                $onImageFound($image, $imageYPointer);
                $tempImage = imagecreatefromjpeg($folder.'/'.$image->getFile());
                imagecopy($spriteImage, $tempImage, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
                imagedestroy($tempImage);
                $imageYPointer = $imageYPointer + $image->getHeight();
            }else{
                $this->logger->info("Found file with filetype: " . exif_imagetype($folder .'/'. $image->getFile()) . ". Image: " . $image->getFile());
            }
        }
        imagepng($spriteImage, $folder . '/' .self::SPRITE.'.png', 9, PNG_ALL_FILTERS); // Save image to file
        imagedestroy($spriteImage);
    }

    private function getImagesFromFolder($folder)
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
                $this->logger->info("FILE TYPE: " . $output["mime"]);
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