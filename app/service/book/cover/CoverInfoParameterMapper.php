<?php

class CoverInfoParameterMapper {

    /** @var  ImageService */
    private $imageService;

    function __construct()
    {
        $this->imageService = App::make('ImageService');
    }


    public function create(){
        return new CoverInfoParameters(Input::get('book_type_of_cover'), $this->saveImage(), true);
    }

    public function saveImage()
    {
        $authorImage = null;
        $imageSelfUpload = Input::get('coverInfoSelfUpload');
        if($imageSelfUpload){
            if(Input::hasFile('book_cover_image')){
                $imageFile = Input::file('book_cover_image');
                $bookTitle = Input::get('book_title');
                $authorImage = $this->imageService->saveUploadImage($imageFile, $bookTitle);
            }
        }else{
            if (Input::get('coverInfoUrl') != '') {
                $authorImage = $this->imageService->saveImageFromUrl(Input::get('coverInfoUrl'));
            }
        }
        return $authorImage;
    }
}
