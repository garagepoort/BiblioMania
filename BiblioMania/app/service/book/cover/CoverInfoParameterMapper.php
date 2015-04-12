<?php

class CoverInfoParameterMapper {

    /** @var  ImageService */
    private $imageService;

    function __construct()
    {
        $this->imageService = App::make('ImageService');
    }


    public function create(){
        return new CoverInfoParameters(Input::get('book_type_of_cover'), $this->getImage());
    }

    private function getImage(){
        if (Input::get('coverInfoSelfUpload')) {
            return Input::file('book_cover_image');
        } else {
            if (Input::get('coverInfoUrl') != '') {
                return $this->imageService->getImage(Input::get('coverInfoUrl'));
            }
        }
    }
}