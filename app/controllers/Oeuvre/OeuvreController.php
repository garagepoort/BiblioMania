<?php

/**
 * Created by PhpStorm.
 * User: davidmaes
 * Date: 22/08/15
 * Time: 03:04
 */
class OeuvreController extends Controller
{

    /** @var  OeuvreToParameterMapper */
    private $oeuvreToParameterMapper;
    /** @var  OeuvreService */
    private $oeuvreService;
    /** @var  BookFromAuthorService */
    private $bookFromAuthorService;

    function __construct()
    {
        $this->oeuvreService = App::make('OeuvreService');
        $this->oeuvreToParameterMapper = App::make('OeuvreToParameterMapper');
        $this->bookFromAuthorService = App::make('BookFromAuthorService');
    }

    public function saveBookFromAuthors(){
        $authorId = Input::get('author_id');
        $oeuvre = Input::get('oeuvre');

        $this->oeuvreService->saveBookFromAuthors($this->oeuvreToParameterMapper->mapToOeuvreList($oeuvre), $authorId);
        return Response::make(200);
    }

    public function updateBookFromAuthorPublicationYear(){
        $id = Input::get('pk');
        $value = Input::get('value');
        try {
            $this->bookFromAuthorService->updateYear($id, $value);
        }catch (ServiceException $e){
            return ResponseCreator::createExceptionResponse($e);
        }
    }

}