<?php

class CoverInfoParameterMapper {

    /** @var  ImageService */
    private $imageService;

    function __construct()
    {
        $this->imageService = App::make('ImageService');
    }


    public function create(){
        return new CoverInfoParameters(Input::get('book_type_of_cover'), $this->getImage(), Input::get('coverInfoSelfUpload'));
    }

    public function getImage()
    {
        $image = null;
        $imageSelfUpload = Input::get('coverInfoSelfUpload');
        if($imageSelfUpload){
            if(Input::hasFile('book_cover_image')){
                $image = Input::file('book_cover_image');
            }
        }else{
            if (Input::get('coverInfoUrl') != '') {
                $image = Input::get('coverInfoUrl');
            }
        }
        return $image;
    }
}
