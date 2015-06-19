<?php
class images_to_sprite {

    private $heightSprite;

    function images_to_sprite($folder,$output,$x) {
        $this->folder = ($folder ? $folder : 'myfolder'); // Folder name to get images from, i.e. C:\\myfolder or /home/user/Desktop/folder
        $this->filetypes = array('jpg'=>true,'png'=>false,'jpeg'=>false,'gif'=>false); // Acceptable file extensions to consider
        $this->output = ($output ? $output : 'mysprite'); // Output filenames, mysprite.png and mysprite.css
        $this->x = $x; // Width of images to consider
        $this->images = array();
    }

    function create_sprite() {
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        // Read through the directory for suitable images
        if($handle = opendir($this->folder)) {
            while (false !== ($file = readdir($handle))) {
                $split = explode('.',$file);
                // Ignore non-matching file extensions
                if($file[0] == '.' || !isset($this->filetypes[$split[count($split)-1]]))
                    continue;
                // Get image size and ensure it has the correct dimensions
                $output = getimagesize($this->folder.'/'.$file);
                if($output[0] != $this->x)
                    continue;
                // Image will be added to sprite, add to array
                $logger->info("FILE TYPE: " . $output["mime"]);
                $this->y = $output[1];
                array_push($this->images, new Image($this->x, $this->y, $file));
                $this->heightSprite = $this->heightSprite + $this->y;
            }
            closedir($handle);
        }

        $im = imagecreatetruecolor($this->x,$this->heightSprite);

        // Add alpha channel to image (transparency)
        imagesavealpha($im, true);
        $alpha = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefill($im,0,0,$alpha);

        // Append images to sprite and generate CSS lines

        $fp = fopen($this->output.'.css','w');
        $imageYPointer = 0;
        fwrite($fp,'.'.$this->output.' { width: '.$this->x.'px; height: '.$this->y.'px; background-image: url('.$this->output.'.png); text-align:center; }'."\n");
        /** @var Image $image */
        $counter = 0;
        foreach($this->images as $image) {
            fwrite($fp,'.'.$this->output.$imageYPointer.' { background-position: -0px -'.$imageYPointer.'px; }'."\n");
            $im2 = imagecreatefromjpeg($this->folder.'/'.$image->getFile());
            imagecopy($im, $im2, 0, $imageYPointer, 0, 0, $image->getWidth(), $image->getHeight());
            $imageYPointer = $imageYPointer + $image->getHeight();
        }
        fclose($fp);
        imagepng($im,$this->output.'.png'); // Save image to file
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