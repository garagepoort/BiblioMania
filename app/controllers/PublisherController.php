<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */

class PublisherController extends BaseController{

    private $publisherFolder = "publisher/";

    /** @var  PublisherService */
    private $publisherService;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
    }


    public function getPublisher($id){
        $publisher = Publisher::with(array('books', 'first_print_infos'))->find($id);
        return View::make($this->publisherFolder . 'publisher')->with(array(
            'title' => 'Uitgever',
            'countries' => $this->publisherService->getCountriesFromPublisher($id),
            'publisher' => $publisher
        ));
    }

    public function getPublishersList(){
        $publishers = $this->publisherService->getPublishers();
        return View::make($this->publisherFolder . 'publishersList')->with(array(
            'title' => 'Editeer uitgevers',
            'publishers' => $publishers
        ));
    }

    public function deletePublisher(){
        $id = Input::get('publisherId');
        try {
            $this->publisherService->deletePublisher($id);
        }catch (ServiceException $e){
            return ResponseCreator::createExceptionResponse($e);
        }
    }

    public function editPublisher(){
        $id = Input::get('pk');
        $value = Input::get('value');

        try {
            $this->publisherService->updatePublisher($id, $value);
        }catch (ServiceException $e){
            return ResponseCreator::createExceptionResponse($e);
        }
    }

    public function mergePublishers(){
        $publisher1_id = Input::get('publisher1_id');
        $publisher2_id = Input::get('publisher2_id');
        $mergeToFirst = Input::get('mergeToFirst');
        if($mergeToFirst != null && $mergeToFirst == false){
            $this->publisherService->mergePublishers($publisher2_id, $publisher1_id);
        }else{
            $this->publisherService->mergePublishers($publisher1_id, $publisher2_id);
        }
    }
}