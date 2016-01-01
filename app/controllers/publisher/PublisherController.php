<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 23/01/15
 * Time: 20:42
 */
class PublisherController extends BaseController
{

    private $publisherFolder = "publisher/";

    /** @var  PublisherService */
    private $publisherService;

    function __construct()
    {
        $this->publisherService = App::make('PublisherService');
    }

    public function getPublishers()
    {
        return array_map(function($item){
            $publisherToJson = new PublisherToJsonAdapter($item);
            return $publisherToJson->mapToJson();
        }, $this->publisherService->getPublishers()->all());
    }

    public function getPublisherSeries($publisherId)
    {
        $result = array();
        foreach($this->publisherService->getPublisherSeries($publisherId) as $serie){
            $publisherSerieToJson = new PublisherSerieToJsonAdapter($serie);
            array_push($result, $publisherSerieToJson->mapToJson());
        }
        return $result;
    }

    public function getPublisherBooks($publisherId)
    {
        $result = array();
        foreach($this->publisherService->getPublisherBooks($publisherId) as $book){
            $bookToJson = new BookToJsonAdapter($book);
            array_push($result, $bookToJson->mapToJson());
        }
        return $result;
    }

    public function getPublisher($id)
    {
        $publisher = Publisher::with(array('books', 'first_print_infos'))->find($id);
        return View::make($this->publisherFolder . 'publisher')->with(array(
            'title' => 'Uitgever',
            'countries' => $this->publisherService->getCountriesFromPublisher($id),
            'publisher' => $publisher
        ));
    }

    public function getPublishersList()
    {
        $publishers = $this->publisherService->getPublishers();
        return View::make($this->publisherFolder . 'publishersList')->with(array(
            'title' => 'Editeer uitgevers',
            'publishers' => $publishers
        ));
    }

    public function deletePublisher()
    {
        $id = Input::get('publisherId');
        $this->publisherService->deletePublisher($id);
    }

    public function editPublisher()
    {
        $id = Input::get('pk');
        $value = Input::get('value');

        $this->publisherService->updatePublisher($id, $value);
    }

    public function mergePublishers()
    {
        $publisher1_id = Input::get('publisher1_id');
        $publisher2_id = Input::get('publisher2_id');
        $mergeToFirst = Input::get('mergeToFirst');
        if ($mergeToFirst != null && $mergeToFirst == false) {
            $this->publisherService->mergePublishers($publisher2_id, $publisher1_id);
        } else {
            $this->publisherService->mergePublishers($publisher1_id, $publisher2_id);
        }
    }
}