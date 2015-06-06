<?php

class AuthorInfoParameterMapper {

    /** @var  DateService */
    private $dateService;
    /** @var ImageService */
    private $imageService;
    /** @var  OeuvreToParameterMapper */
    private $oeuvreToParameterMapper;

    function __construct()
    {
        $this->dateService = App::make('DateService');
        $this->imageService = App::make('ImageService');
        $this->oeuvreToParameterMapper = App::make('OeuvreToParameterMapper');
    }


    public function create(){
        $author_date_of_birth = $this->dateService->createDate(Input::get('author_date_of_birth_day'), Input::get('author_date_of_birth_month'), Input::get('author_date_of_birth_year'));
        $author_date_of_death = $this->dateService->createDate(Input::get('author_date_of_death_day'), Input::get('author_date_of_death_month'), Input::get('author_date_of_death_year'));

        return new AuthorInfoParameters(
            Input::get('author_name'),
            Input::get('author_firstname'),
            Input::get('author_infix'),
            $author_date_of_birth,
            $author_date_of_death,
            Input::get('bookFromAuthorTitle'),
            $this->getImage(),
            $this->oeuvreToParameterMapper->mapToOeuvreList(Input::get('oeuvre')),
            Input::get('authorImageSelfUpload')
        );
    }

    public function getImage()
    {
        $image = null;
        $imageSelfUpload = Input::get('authorImageSelfUpload');
        if($imageSelfUpload){
            if(Input::hasFile('author_image')){
                $image = Input::file('author_image');
            }
        }else{
            if (Input::get('authorImageUrl') != '') {
                $image = Input::get('authorImageUrl');
            }
        }
        return $image;
    }
}