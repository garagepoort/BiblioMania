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
        $spriteImages = self::getImagesFromFolder($folder);

        $counter = 1;

        /** @var SpriteImage $spriteImage */
        foreach($spriteImages as $spriteImage){
            $imageYPointer = 0;
            $filename = self::SPRITE . '_' . $counter . '.jpg';

            $concatenatedImage = $this->createSpriteImageToBeFilledIn($spriteImage);

            /** @var Image $image */
            foreach($spriteImage->getImages() as $image) {

                if(exif_imagetype($folder .'/'. $image->getFile()) === IMAGETYPE_JPEG){
                    $this->logger->info("Found file: " . $image->getFile());
                    $tempImage = imagecreatefromjpeg($folder.'/'.$image->getFile());
                    imagecopy($concatenatedImage, $tempImage, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
                    imagedestroy($tempImage);
                    $onImageFound($image, $imageYPointer, $filename);
                    $imageYPointer = $imageYPointer + $image->getHeight();
                }else{
                    $this->logger->info("Found file with filetype: " . exif_imagetype($folder .'/'. $image->getFile()) . ". Image: " . $image->getFile());
                }
            }

            imagejpeg($concatenatedImage, $folder . '/' . $filename, 80); // Save image to file
            imagedestroy($concatenatedImage);
            $counter++;
        }
    }

    public function getAllImageFileNamesFromFolder($folder){
        $fileTypes = array('jpg'=>true);
        $images = array();
        if ($handle = opendir($folder)) {
            while (false !== ($file = readdir($handle))) {
                if ($this->isFileNotACorrectImageFile($file, $fileTypes)) continue;
                array_push($images, $file);
            }
            closedir($handle);
        }
        return $images;
    }

    private function getImagesFromFolder($folder)
    {
        $fileTypes = array('jpg'=>true);
        $spriteImages = array();
        $counter = 0;
        if ($handle = opendir($folder)) {
            $spriteImage = new SpriteImage();
            while (false !== ($file = readdir($handle))) {

                if ($this->isFileNotACorrectImageFile($file, $fileTypes)) continue;

                // Get image size and ensure it has the correct dimensions
                $output = getimagesize($folder . '/' . $file);
                $width = $output[0];
                $height = $output[1];
                $spriteImage->addImage(new Image($width, $height, $file));

                $counter++;
                if($counter == 50){
                    array_push($spriteImages, $spriteImage);
                    $counter = 0;
                    $spriteImage = new SpriteImage();
                }

            }
            if($counter !== 0){
                array_push($spriteImages, $spriteImage);
            }
            closedir($handle);
        }
        return $spriteImages;
    }

    /**
     * @param $file
     * @param $fileTypes
     * @param $split
     * @return bool
     */
    private function isFileNotACorrectImageFile($file, $fileTypes)
    {
        $split = explode('.', $file);
        return $file[0] == '.' || !isset($fileTypes[$split[count($split) - 1]]) || substr($file, 0, 6) === "sprite";
    }

    /**
     * @param SpriteImage $spriteImage
     * @return resource
     */
    private function createSpriteImageToBeFilledIn(SpriteImage $spriteImage)
    {
        $concatenatedImage = imagecreatetruecolor(self::WIDTH, $spriteImage->getSpriteHeight());
        imagesavealpha($concatenatedImage, true);
        $alpha = imagecolorallocatealpha($concatenatedImage, 0, 0, 0, 127);
        imagefill($concatenatedImage, 0, 0, $alpha);
        return $concatenatedImage;
    }
}