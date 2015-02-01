<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */

class PublisherController extends BaseController{

    private $publisherFolder = "publisher/";

    public function getPublisher($id){
        $publisher = Publisher::with(array('countries', 'books', 'first_print_infos'))->find($id);
        return View::make($this->publisherFolder . 'publisher')->with(array(
            'title' => 'Uitgever',
            'publisher' => $publisher
        ));
    }

    public function getPublishersList(){
        $publishers = Publisher::with('first_print_infos', 'books')->orderBy('name', 'asc')->get();
        return View::make($this->publisherFolder . 'publishersList')->with(array(
            'title' => 'Editeer uitgevers',
            'publishers' => $publishers
        ));
    }

    public function deletePublisher(){
        $id = Input::get('publisherId');

        $publisher = Publisher::with('books', 'first_print_infos')->find($id);
        if($publisher != null && count($publisher->books) == 0 && count($publisher->first_print_infos) == 0){
            $publisher->delete();
        }else{
            return Response::json(array(
                'code'      =>  412,
                'message'   =>  'Een uitgever met boeken mag niet verwijdert worden.'
            ), 412);
        }
    }

    public function editPublisher(){
        $id = Input::get('pk');
        $name = Input::get('name');
        $value = Input::get('value');

        $publisher = Publisher::find($id);
        if($publisher != null){
            if($name == 'name'){
                $publisher->name = $value;
            }

            $publisher->save();
        }
    }

    public function mergePublishers(){
        $publisher1_id = Input::get('publisher1_id');
        $publisher2_id = Input::get('publisher2_id');
        $mergeToFirst = Input::get('mergeToFirst');
        if($mergeToFirst != null && $mergeToFirst == false){
            App::make('PublisherService')->mergePublishers($publisher2_id, $publisher1_id);
        }else{
            App::make('PublisherService')->mergePublishers($publisher1_id, $publisher2_id);
        }
    }
}